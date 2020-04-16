<?php
	ini_set("memory_limit","500M");
	header('Content-type: application/json');

	include "../_libs/pretty_json.php";
	include "../_libs/simple_html_dom.php";

	$news = array();

	$page = $_GET["page"];

	if($page == "") $page = 1;

	$url = "http://anmtv.xpg.com.br/";

	if($page > 1) $url .= "page/".$page."/";
	
	$html = file_get_html($url);

	$content = $html->find('section#noticias', 0);

	foreach ($content->find("article") as $item) {
		$new = array();

		$image = $item->find('img', 0);
		$image = $image->src;

		$title = $item->find('h2', 0);
		$title = $title->plaintext;

		$category = $item->find('div.titulo-categoria-noticia', 0);
		$category = $category->plaintext;

		$id = $item->find('a', 0);
		$id = str_replace("http://anmtv.xpg.com.br", "", $id->href);

		$new["id"]					= $id;
		$new["title"]				= $title;
		$new["category"]			= $category;
		$new["image"]				= $image;

		array_push($news, $new);
	}

	print_r(pretty_json(json_encode($news)));

?>