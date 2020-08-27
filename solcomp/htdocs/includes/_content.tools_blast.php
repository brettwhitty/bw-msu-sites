 <h2>BLAST Search</h2>
 <script type="text/javascript" src="/js/tools_blast.js"></script>
<div id="search_header">
<h3>Solanaceae Genomics Resource BLAST Server</h3>
</div>
<div id="search_form_div">
<form target="_blank" id="search_form" action="http://sol-blast.plantbiology.msu.edu/cgi-bin/process_blast.pl" method="post" name="blast" enctype="multipart/form-data">

<fieldset>
<legend>Select type of BLAST Search</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="5px">
<tr>
<td valign="baseline"><select id="blast_program" name="blast_program" onchange="changeProgramDesc()">
<option value="blastn" selected="selected">blastn</option>

<option value="blastp">blastp</option>
<option value="blastx">blastx</option>
<option value="tblastn">tblastn</option>
<option value="tblastx">tblastx</option>
</select>
</td>
<td valign="baseline"><h2 id="program_desc" class="small_s">Search a nucleotide database using a nucleotide query</h2></td>

</tr>
</table>
</fieldset>
<fieldset>
<legend>Enter Query Sequence</legend>
<h2 id="seq_textarea" class="small_s">Enter DNA FASTA sequence:</h2>
<textarea id='query_fasta' name="query" cols="70" rows="10"></textarea>

<h2 id="seq_file" class="small_s">or upload a file of DNA FASTA sequence:</h2>
<table border="0" cellpadding="2px"
width="100%"><tr><td><input id="queryfile" name="queryfile" type="file" size="30" />
</td><td><input type="reset" name="reset" value="Clear Form"></td></tr></table>
</fieldset>

<fieldset>
<legend>Choose Database to Search</legend>
<h2 class="small_s">Select the BLAST database you would like to search:</h2>
<table border="0" cellpadding="0px" width="100%;" cellspacing="0px">

<tr><td>
<div style='float: right'>
<a href='/projects_solcomp_version.php#blast_databases'>Click here</a> for more info on available BLAST databases 
</div>
<select name="database" size="1" id="database_select">
<!--
    <option value="" disabled> -- model genomes -- </option>
    <option value="1">Arabidopsis (TAIR8)</option>
    <option value="2">Grape (v1)</option>
    <option value="3">Medicago (2.0)</option>
    <option value="4">Poplar (v1.1)</option>
    -->
</select>
</td>
</tr>

</table>
<span style='font-size: 0.85em; color: #6F6F6F;'>BLAST databases last updated on <?php echo file_get_contents("http://sol-blast.plantbiology.msu.edu/cgi-bin/get_version.cgi"); ?></span>
</fieldset>

<fieldset>
<legend>Submit BLAST Search</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="5px">
<tr>
<td valign="baseline"><input id="submit_button" type="submit" value="Submit BLAST Search" /></td>

<td valign="baseline"><h2 id="search_type" class="small_s">Search selected nucleotide database using blastn</h2></td>
</tr>
</table>
</fieldset>
<fieldset>
<legend>Optional BLAST Parameters</legend>
<table width="100%" border="0" cellspacing="10px" cellpadding="2px" id="options">
<tr>

<td>Expect Threshold:</td>
<td><select name="expect">
<option value="1e-200">1e-200</option>
<option value="1e-100">1e-100</option>
<option value="1e-50">1e-50</option>
<option value="1e-20">1e-20</option>

<option value="1e-10">1e-10</option>
<option value="1e-5">1e-5</option>
<option value="1e-4">1e-4</option>
<option value="1e-3">1e-3</option>
<option value="1e-2">1e-2</option>
<option value="1e-1">1e-1</option>

<option value="1">1</option>
<option value="10" selected="selected">10</option>
<option value="100">100</option>
<option value="1000">1000</option>
</select>
</td>
</tr>

<tr>
<td>Max Number of Alignments:</td>
<td><select name="max_align">
<option value="1">1</option>
<option value="5">5</option>
<option value="10">10</option>
<option value="20">20</option>

<option value="50">50</option>
<option value="100" selected="selected">100</option>
<option value="250">250</option>
<option value="500">500</option>
</select>
</td>
</tr>

<tr>
<td>Max Number of Descriptions:</td>
<td><select name="max_desc">
<option value="1">1</option>
<option value="5">5</option>
<option value="10">10</option>
<option value="20">20</option>

<option value="50">50</option>
<option value="100" selected="selected">100</option>
<option value="250">250</option>
<option value="500">500</option>
</select></td>
</tr>
<tr id="word_size">

<td>Word Length:</td>
<td><select name="word_length">
<option value="7">7</option>
<option value="11" selected="selected">11</option>
<option value="15">15</option>
</select></td>
</tr>

<tr>
<td>Filter:</td>
<td><select name="filter" id="filter_select">
<option value="none" selected="selected">none</option>
<option value="dust">dust</option>
</select>
</td>

</tr>
<tr>
<td>View Filter:</td>
<td><select name="view_filter">
<option value="no" selected="selected">no</option>
<option value="yes">yes</option>
</select>

</td>
</tr>
<tr id="matrix" style="display:none;">
<td>Matrix:</td>
<td><select name="matrix">
<option value="PAM30">PAM30</option>
<option value="PAM70">PAM70</option>

<option value="BLOSUM80">BLOSUM80</option>
<option value="BLOSUM62" selected="selected">BLOSUM62</option>
<option value="BLOSUM45">BLOSUM45</option>
</select></td>
</tr>
<tr id="strand">
<td>Strand:</td>

<td><select name="strand">
<option value="both" selected="selected">both</option>
<option value="top">top</option>
<option value="bottom">bottom</option>
</select>
</td>
</tr>

</table>
</fieldset>
</form>
</div>
<div id="search_results">
</div>
