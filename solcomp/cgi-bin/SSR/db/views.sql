create view ssr_summary as select sdbx.accession as taxon_id, o.common_name as organism,
       sf.uniquename as assembly,
       f.name as ssr_desc,
       length(fp.value) as repeat_len,
       l.fmin as fmin, l.fmax as fmax, l.strand as strand
from feature f, featureloc l, feature sf, cvterm c, organism o, feature_dbxref fd, db, dbxref dbx,
       feature_dbxref sfd, db sdb, dbxref sdbx,
       cvterm cv,
       featureprop fp, cvterm cvt
where f.feature_id = l.feature_id and sf.feature_id = l.srcfeature_id and f.type_id = c.cvterm_id
       and f.organism_id = o.organism_id and f.feature_id = fd.feature_id
       and fd.dbxref_id = dbx.dbxref_id and db.db_id = dbx.db_id
       and sf.feature_id = sfd.feature_id and sfd.dbxref_id = sdbx.dbxref_id
       and sf.type_id = cv.cvterm_id
       and f.feature_id = fp.feature_id and cvt.cvterm_id = fp.type_id
       and sdb.db_id = sdbx.db_id and sdb.name = 'taxon' and cvt.name = 'motif'
       and db.name = 'GFF_source' and dbx.accession = 'SSR_putative'
       order by assembly, fmin;

grant select on ssr_summary to access;

create view ssr_seq_summary as select x.accession as taxon_id, o.common_name as organism, count(f.feature_id),
       sum(length(f.residues)) as len
from feature f, cvterm c, feature_dbxref fd, dbxref x, db, organism o
where f.feature_id = fd.feature_id and f.organism_id = o.organism_id
      and fd.dbxref_id = x.dbxref_id and db.db_id = x.db_id
      and f.type_id = c.cvterm_id and c.name in ('contig', 'sequence_assembly')
      and db.name = 'taxon' and length(f.residues) > 0 group by taxon_id, organism;
