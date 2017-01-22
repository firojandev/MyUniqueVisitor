var xmlhttp;
if (window.XMLHttpRequest)
  xmlhttp=new XMLHttpRequest();
else
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

function cuv_show (stat, plugin_url, blog_url) {

  document.getElementById("cuv_stats_title").innerHTML = '<img src="'+plugin_url+'" title="Loading Stats" alt="Loading Stats" border="0">';
  xmlhttp.onreadystatechange=cuv_change_stat;
  xmlhttp.open("GET",blog_url+"/wp-admin/admin-ajax.php?action=cuvstats&reqstats="+stat,true);
  xmlhttp.send();
}

function cuv_change_stat () {

  if (xmlhttp.readyState==4 && xmlhttp.status==200) {

     var rt = xmlhttp.responseText;
     var cuvdata = rt.split('~');
     document.getElementById("cuv_stats_title").innerHTML = cuvdata[0];
     document.getElementById("cuv_lds").innerHTML = cuvdata[1];
     document.getElementById("cuv_lws").innerHTML = cuvdata[2];
     document.getElementById("cuv_lms").innerHTML = cuvdata[3];
     document.getElementById("cuv_lys").innerHTML = cuvdata[4];
  }
}
