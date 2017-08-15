<?php
session_start();
$domain=$_SERVER['HTTP_HOST'];
$ruta_html="http://".$domain."/modulos";
$ruta_js="http://".$domain."/site_media/js";
$ruta_imagenes="http://".$domain."/site_media/imagenes";
$ruta_css="http://".$domain."/site_media/css";
$ruta_includes="http://".$domain."/includes";
$ruta_main="http://".$domain."/";
$ruta_index_header="Location:http://".$domain."/";
$ruta_documentos_requisitos = "http://".$domain."/documentos/requisitos/";
$ruta_documentos_sintesis = "http://".$domain."/documentos/sintesis/";
?>