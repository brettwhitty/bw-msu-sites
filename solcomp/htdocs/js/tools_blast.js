function BrowserDetect() {
   var ua = navigator.userAgent.toLowerCase();

   // browser engine name
   this.isGecko       = (ua.indexOf('gecko') != -1 && ua.indexOf('safari') == -1);
   this.isAppleWebKit = (ua.indexOf('applewebkit') != -1);

   // browser name
   this.isKonqueror   = (ua.indexOf('konqueror') != -1);
   this.isSafari      = (ua.indexOf('safari') != - 1);
   this.isOmniweb     = (ua.indexOf('omniweb') != - 1);
   this.isOpera       = (ua.indexOf('opera') != -1);
   this.isIcab        = (ua.indexOf('icab') != -1);
   this.isAol         = (ua.indexOf('aol') != -1);
   this.isIE          = (ua.indexOf('msie') != -1 && !this.isOpera && (ua.indexOf('webtv') == -1) );
   this.isMozilla     = (this.isGecko && ua.indexOf('gecko/') + 14 == ua.length);
   this.isFirebird    = (ua.indexOf('firebird/') != -1);
   this.isNS          = ( (this.isGecko) ? (ua.indexOf('netscape') != -1) : ( (ua.indexOf('mozilla') != -1) && !this.isOpera && !this.isSafari && (ua.indexOf('spoofer') == -1) && (ua.indexOf('compatible') == -1) && (ua.indexOf('webtv') == -1) && (ua.indexOf('hotjava') == -1) ) );

   // spoofing and compatible browsers
   this.isIECompatible = ( (ua.indexOf('msie') != -1) && !this.isIE);
   this.isNSCompatible = ( (ua.indexOf('mozilla') != -1) && !this.isNS && !this.isMozilla);

   // rendering engine versions
   this.geckoVersion = ( (this.isGecko) ? ua.substring( (ua.lastIndexOf('gecko/') + 6), (ua.lastIndexOf('gecko/') + 14) ) : -1 );
   this.equivalentMozilla = ( (this.isGecko) ? parseFloat( ua.substring( ua.indexOf('rv:') + 3 ) ) : -1 );
   this.appleWebKitVersion = ( (this.isAppleWebKit) ? parseFloat( ua.substring( ua.indexOf('applewebkit/') + 12) ) : -1 );

   // browser version
   this.versionMinor = parseFloat(navigator.appVersion);

   // correct version number
   if (this.isGecko && !this.isMozilla) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('/', ua.indexOf('gecko/') + 6) + 1 ) );
   }
   else if (this.isMozilla) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('rv:') + 3 ) );
   }
   else if (this.isIE && this.versionMinor >= 4) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('msie ') + 5 ) );
   }
   else if (this.isKonqueror) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('konqueror/') + 10 ) );
   }
   else if (this.isSafari) {
      this.versionMinor = parseFloat( ua.substring( ua.lastIndexOf('safari/') + 7 ) );
   }
   else if (this.isOmniweb) {
      this.versionMinor = parseFloat( ua.substring( ua.lastIndexOf('omniweb/') + 8 ) );
   }
   else if (this.isOpera) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('opera') + 6 ) );
   }
   else if (this.isIcab) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('icab') + 5 ) );
   }

   this.versionMajor = parseInt(this.versionMinor);

   // dom support
   this.isDOM1 = (document.getElementById);
   this.isDOM2Event = (document.addEventListener && document.removeEventListener);

   // css compatibility mode
   this.mode = document.compatMode ? document.compatMode : 'BackCompat';

   // platform
   this.isWin    = (ua.indexOf('win') != -1);
   this.isWin32  = (this.isWin && ( ua.indexOf('95') != -1 || ua.indexOf('98') != -1 || ua.indexOf('nt') != -1 || ua.indexOf('win32') != -1 || ua.indexOf('32bit') != -1 || ua.indexOf('xp') != -1) );
   this.isMac    = (ua.indexOf('mac') != -1);
   this.isUnix   = (ua.indexOf('unix') != -1 || ua.indexOf('sunos') != -1 || ua.indexOf('bsd') != -1 || ua.indexOf('x11') != -1)
   this.isLinux  = (ua.indexOf('linux') != -1);

   // specific browser shortcuts
   this.isNS4x = (this.isNS && this.versionMajor == 4);
   this.isNS40x = (this.isNS4x && this.versionMinor < 4.5);
   this.isNS47x = (this.isNS4x && this.versionMinor >= 4.7);
   this.isNS4up = (this.isNS && this.versionMinor >= 4);
   this.isNS6x = (this.isNS && this.versionMajor == 6);
   this.isNS6up = (this.isNS && this.versionMajor >= 6);
   this.isNS7x = (this.isNS && this.versionMajor == 7);
   this.isNS7up = (this.isNS && this.versionMajor >= 7);

   this.isIE4x = (this.isIE && this.versionMajor == 4);
   this.isIE4up = (this.isIE && this.versionMajor >= 4);
   this.isIE5x = (this.isIE && this.versionMajor == 5);
   this.isIE55 = (this.isIE && this.versionMinor == 5.5);
   this.isIE5up = (this.isIE && this.versionMajor >= 5);
   this.isIE6x = (this.isIE && this.versionMajor == 6);
   this.isIE6up = (this.isIE && this.versionMajor >= 6);

   this.isIE4xMac = (this.isIE4x && this.isMac);

   } //end BrowserDetect()

   var detectBrowser = new BrowserDetect();

function setFilterOptions(program){
 var select_elem = document.getElementById('filter_select');
 if (program == 'blastn'){
    select_elem.options.length = 0;
    var opt_none = new Option("none", "none", true, true);
    var opt_dust = new Option("dust", "dust", false, false);
    select_elem.options[0] = opt_none;
    select_elem.options[1] = opt_dust;
 }
 else{
    select_elem.options.length = 0;
    var opt_none = new Option("none", "none", true, true);
    var opt_seg = new Option("seg", "seg", false, false);
    var opt_xnu = new Option("xnu", "xnu", false, false);
    var opt_segxnu = new Option("seg+xnu", "seg+xnu", false, false);
    select_elem.options[0] = opt_none;
    select_elem.options[1] = opt_seg;
    select_elem.options[2] = opt_xnu;
    select_elem.options[3] = opt_segxnu; 
 }
}

function setDatabaseOptions(program){
 var select_elem = document.getElementById('database_select');
 if (program == 'blastn' || program == 'tblastn' || program == 'tblastx' ){
    select_elem.options.length = 0;
    select_elem.disabled = false;

    var database_descriptions = {
        "40": "Potato BACs",
        "1": "Potato Chr. 6 BACs (RHPOTKEY)", 
        "41": "Potato BAC Ends",
        "44": "Tobacco 454 BACs",
        "45": "Tobacco Sheared BACs",
        "46": "Tobacco Methyl-Filtered CAP3 Assemblies",
        "42": "Tomato BACs",
        "43": "Tomato BAC Ends",
        "15": "Solanaceae BACs (all species)",
        "13": "Solanum tuberosum BACs",
        "7": "Solanum lycopersicum BACs",
        "2": "Solanum bulbocastanum BACs",
        "14": "Solanum demissum BACs",
        "12": "Solanum melongena BACs",
        "8": "Solanum pimpinellifolium BACs",
        "5": "Capsicum annuum BACs",
        "6": "Capsicum frutescens BACs",
        "10": "Nicotiana tabacum BACs",
        "9": "Nicotiana sylvestris BACs",
        "11": "Nicotiana tomentosiformis BACs",
        "3": "Petunia integrifolia subsp. inflata BACs",
        "4": "Atropa belladonna BACs",
        "28": "Solanaceae BACs MAKER-predicted transcripts",
        "49": "Tobacco sheared BAC assemblies MAKER-predicted transcripts",
        "51": "Tobacco 454 BAC assemblies MAKER-predicted transcripts",
        "16": "Solanaceae PUTs (all species)",
        "26": 'Solanum tuberosum PUTs', 
        "19": 'Solanum lycopersicum PUTs',
        "21": 'Nicotiana tabacum PUTs', 
        "22": 'Capsicum annuum PUTs',
        "24": 'Nicotiana benthamiana PUTs',
        "17": "Nicotiana langsdorffii x Nicotiana sanderae PUTs", 
        "20": 'Nicotiana sylvestris PUTs',
        "18": 'Petunia x hybrida PUTs', 
        "27": 'Solanum chacoense PUTs', 
        "25": 'Solanum habrochaites PUTs',
        "23": 'Solanum pennellii PUTs'
                                };
    var selected_flag = true;
    var i = 0;
    for (var db_id in database_descriptions) {       
        if (i > 0) {
            selected_flag = false;
        }
        select_elem.options[i] = new Option(database_descriptions[db_id], db_id, selected_flag, selected_flag);
        i++;
    }
} else {
    select_elem.options.length = 0;
    select_elem.options[0] = new Option("Solanaceae BACs MAKER-predicted proteins", "47", true, true);
    select_elem.options[1] = new Option("Tobacco sheared BAC assemblies MAKER-predicted proteins", "48", false, false);
    select_elem.options[2] = new Option("Tobacco 454 BAC assemblies MAKER-predicted proteins", "50", false, false);
    select_elem.options[3] = new Option("TAIR Arabidopsis Proteome Release 8", "29", false, false);
    select_elem.options[4] = new Option("Grape Proteome v1", "30", false, false);
    select_elem.options[5] = new Option("Medicago Proteome v2.0", "31", false, false);
    select_elem.options[6] = new Option("Poplar Proteome v1.1", "32", false, false);
    
 }
}

function checkFASTA() {
    if (
        document.getElementById('queryfile').value != ''
        || document.getElementById('query_fasta').value.match(/^>.*\n([a-zA-Z* -](\n)?){1,}$/)
    ) {
        return true;
    } else {
        return false;
    }
}

function changeProgramDesc(){
var selected_text;
var blast_select = document.getElementById('blast_program');
for (var i = 0; i < blast_select.options.length; i++) {
   if (blast_select.options[i].selected){
     selected_text =  blast_select.options[i].text;
   }
}
var blast_desc;
var seq_textarea;
var seq_file;
var search_type;
switch(selected_text)
{
case "blastn":
  blast_desc = "Search a nucleotide database using a nucleotide query";
  seq_textarea = "Enter a DNA FASTA sequence:";
  seq_file = "or upload a file of DNA FASTA sequence:";
  search_type = "Search selected nucleotide databases using blastn";
  if (detectBrowser.isGecko){
    document.getElementById('strand').style.display = "table-row";
    document.getElementById('word_size').style.display = "table-row";
  }
  else {
    document.getElementById('strand').style.display = "block";
    document.getElementById('word_size').style.display = "block";
  }
  document.getElementById('matrix').style.display = "none";
  break;    

case "blastp":
  blast_desc = "Search protein database using a protein query";
  seq_textarea = "Enter a protein FASTA sequence:";
  seq_file = "or upload a file of protein FASTA sequence:";
  search_type = "Search selected protein databases using blastp";
  document.getElementById('strand').style.display = "none";
  document.getElementById('word_size').style.display = "none";
  if (detectBrowser.isGecko){
    document.getElementById('matrix').style.display = "table-row";
  }
  else {
    document.getElementById('matrix').style.display = "block";
  }
  break;

case "blastx":
 blast_desc = "Search protein database using a translated nucleotide query";
 seq_textarea = "Enter a DNA FASTA sequence:";
 seq_file = "or upload a file of DNA FASTA sequence:";
 search_type = "Search selected protein databases using blastx";
 document.getElementById('word_size').style.display = "none";
 if (detectBrowser.isGecko){
    document.getElementById('matrix').style.display = "table-row";
    document.getElementById('strand').style.display = "table-row";
  }
  else {
    document.getElementById('matrix').style.display = "block";
    document.getElementById('strand').style.display = "block";
  }
  break;

case "tblastn":
 blast_desc = "Search translated nucleotide database using a protein query";
 seq_textarea = "Enter a protein FASTA sequence:";
 seq_file = "or upload a file of protein FASTA sequence:";
 search_type = "Search selected nucleotide databases using tblastn";
 document.getElementById('strand').style.display = "none";
 document.getElementById('word_size').style.display = "none"; 
 if (detectBrowser.isGecko){
    document.getElementById('matrix').style.display = "table-row";
  }
  else {
    document.getElementById('matrix').style.display = "block";
  }
 break;

case "tblastx":
 blast_desc = "Search translated nucleotide database using a translated nucleotide query";
 seq_textarea = "Enter a DNA FASTA sequence:";
 seq_file = "or upload a file of DNA FASTA sequence:";
 search_type = "Search selected nucleotide databases using tblastx";
 document.getElementById('word_size').style.display = "none";
 if (detectBrowser.isGecko){
    document.getElementById('matrix').style.display = "table-row";
    document.getElementById('strand').style.display = "table-row";
  }
  else {
    document.getElementById('matrix').style.display = "block";
    document.getElementById('strand').style.display = "block";
  }
 break;
}
document.getElementById('program_desc').innerHTML = blast_desc;
document.getElementById('seq_textarea').innerHTML = seq_textarea;
document.getElementById('seq_file').innerHTML = seq_file;
document.getElementById('search_type').innerHTML = search_type;
setFilterOptions(selected_text);
setDatabaseOptions(selected_text);
return true;
}

window.addEvent('domready', function() {
    
    /*
    var selected_text;
    var blast_select = document.getElementById('blast_program');
    for (var i = 0; i < blast_select.options.length; i++) {
        if (blast_select.options[i].selected){
            selected_text =  blast_select.options[i].text;
        }
    }
    setDatabaseOptions(selected_text);
    */
    
    changeProgramDesc();

    $('search_form').addEvent('submit', function(e){
            new Event(e).stop();

            if (checkFASTA()) {
                this.submit();
            } else {
                window.alert('Query does not appear to be a single sequence record in FASTA format');
            }
    });

});
