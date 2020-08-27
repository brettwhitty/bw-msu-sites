<?php
    require('left_menu.inc.php');
?>
<div id="submenu_content">
<h1>Generic Genome Browser (GBrowse) Databases</h1>
  <h3><a href="/cgi-bin/gbrowse/solanaceae/">Solanaceae Comparative Genome Database</a></h3>
  <p>This database contains all public genomic contig sequence data for the Solanaceae available from GenBank. Currently, our Solanaceae Comparative Genome Database includes BACs from the <a href="http://www.sgn.cornell.edu/about/tomato_sequencing.pl">Tomato Genome Initiative</a> and the <a href="http://potatogenome.net/">Potato Genome Initiative</a>. We will be updating this database quarterly, and will be adding data from the <a href="http://www.pngg.org/tgi/">Tobacco Genome Initaitive</a> once it is released and available in the public sequence databases. </p>
  <p>The sequences are run through the <a href="http://www.yandell-lab.org/software/maker.html">MAKER</a> pipeline to provide gene models, in addition to any previously annotated gene models from the public data.</p>
  <p>Other data and analyses results available for display include:</p>
  <ul>
    <li>Assembled Solanaceae transcript sequences obtained from <a href="http://www.plantgdb.org/">PlantGDB</a> (PUTs) aligned to the genomic sequence (11 species)</li>
    <li><a href="http://www.pir.uniprot.org/">UniProt</a>'s <a href="http://www.expasy.org/sprot/">SwissProt</a> and <a href="http://http://www.uniprot.org/help/uniref">UniRef</a> protein databases aligned to the genomic sequence</li>
    <li>Top hits for the Solanaceae gene models against model dicot proteomes (<a href="http://arabidopsis.org">Arabidopsis</a>, <a href="http://www.genoscope.cns.fr/spip/Vitis-vinifera-e.html">Grape</a>, <a href="http://www.medicago.org/genome/IMGAG/">Medicago</a>, <a href="http://genome.jgi-psf.org/Poptr1_1/Poptr1_1.home.html">Poplar</a>)</li>
    <li><a href="http://www.ebi.ac.uk/interpro/">InterProScan</a> results on the models</li>
    <li>Predicted repeat features (using <a href="http://www.repeatmasker.org/">RepeatMasker</a> and <a href="ftp://ftp.gramene.org/pub/gramene/software/scripts/ssr.pl">ssr.pl</a> from Gramene)</li>
    <li>Predicted ncRNA features (using <a href="http://lowelab.ucsc.edu/tRNAscan-SE/">tRNAscan-SE</a> and <a href="http://www.cbs.dtu.dk/services/RNAmmer/">RNAmmer</a>)</li>
    <li>Results of additional computational analyses</li>
    </ul>
  <h2>Model Dicot Genome Comparative Databases</h2>
  <p>Genome databases for the current public releases of model dicot genomes with tracks of data from comparative analyses against Solanaceae sequence.
  <blockquote>
    <h3><a href="/cgi-bin/gbrowse/arabidopsis/">Arabidopsis Genome Database</a></h3>
    <p>TAIR8 release of the <em>Arabidopsis thaliana</em> genome.</p>
    <h3><a href="/cgi-bin/gbrowse/grape/">Grape Genome Database</a></h3>
    <p>Genoscope v1.1 release of the <em>Vitis vinifera</em> genome.</p>
    <h3><a href="/cgi-bin/gbrowse/poplar/">Poplar Genome Database</a></h3>
    <p>DOE JGI v2 release of the <em>Populus trichocarpa</em> genome.</p>
  </blockquote>
<?php /*
  <div class="notice_box nb_grey">
  <h3>Medicago Genome Database</h3>
  <p>IMGAG v2.0 release of the <em>Medicago truncatula</em> genome.</p>
  <p><em>Currently under development, check back soon.</em></p>
  </div>
 */ ?>
</div>
