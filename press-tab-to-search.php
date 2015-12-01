<?php
/*
 Plugin Name: Press Tab to Search
 Plugin URI: http://onetarek.com/
 Description: Add "press tab to search" feature to google chrome browser for your own website
 Author: oneTarek
 Author URI: http://onetarek.com/
 Version: 1.0
*/

define ( 'PTS_PLUGIN_DIR', dirname(__FILE__)); // Plugin Directory
define ( 'PTS_PLUGIN_URL', plugin_dir_url(__FILE__)); // with forward slash (/). Plugin URL (for http requests).

function pts_create_xml_file(){
	$sitename=get_bloginfo('name');
	$search_url=get_bloginfo('url')."?s={searchTerms}";
	
	$data='<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">';
	$data.='<ShortName>'.$sitename.'</ShortName>';
	$data.='<Description>Use Google to search '.$sitename.'</Description>';
	$data.='<Url type="text/html" template="'.$search_url.'"/>';
	$data.='</OpenSearchDescription>';
	
	$upload_dir = wp_upload_dir(); 
	
	$fp=fopen($upload_dir['basedir']."/opensearchdescription.xml", "w");
	fwrite($fp, $data);
	fclose($fp);

}
function pts_install(){
	pts_create_xml_file();
}
register_activation_hook(__FILE__,'pts_install'); 

function pts_site_head(){
	$upload_dir = wp_upload_dir();
	?>
	<link type="application/opensearchdescription+xml" rel="search" href="<?php echo trailingslashit($upload_dir['baseurl'])?>opensearchdescription.xml"/>
	<?php 
}

add_action("wp_head", "pts_site_head");