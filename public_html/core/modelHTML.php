<?php
class HTML{
    /*
     * Genera un vinculo html.
     * @static
     * @param string $href URl del vinculo.
     * @param string $content Texto del vinculo a mostrar.
     * @para array $optional Atributos extras a incluir dentro del vinculo.
     * @return string Codigo HTML del vinuculo formateado.
     */
    static function a($href, $content, $optional = array()){
        $opt = "";
        foreach($optional as $key => $value){
            $opt .= $key . "=" . $value . " ";
        }
        return "<a href='".$href."' ".$opt.">".$content."</a>";
    }	

    static function singleTable($datos=array(), $encabezado=array(), $atributos=array()){
        $atributo = null;
        foreach($atributos as $attr => $valor){
            $atributo .= $attr . '="' . $valor .'" ';
        }
        $tabla = "<table $atributo >";
        $tabla .= "<thead><tr>";
        if(count($encabezado)<=0){
          foreach ($datos[0] as $campo=>$valor){
            $tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
          }
        }else{
          foreach ($encabezado as $campo){
            $tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
          }
        }
        $tabla .= "</tr></thead><tbody>";

        foreach ($datos as $registro) {
          $tabla .= "<tr>";
          foreach ($registro as $campo => $valor) {
            $tabla .= "<td>".$valor."</td>";
          }
          $tabla .= "</tr>";
        }
        $tabla .= "</tbody></table>";
        
        return $tabla;
    }
	static function TableDeudasPendientes($datos = array(), $encabezado = array(), $id, $class, $opciones=array(),$pref){
        $opt = null;
        $tabla = "<table class='$class' id='$id'>";
        $tabla .= "<thead><tr>";
		$col=0;
        if(count($encabezado)<=0){
			
            foreach ($datos[0] as $campo=>$valor){
                $col=$col+1;
				if(count($encabezado)==$col){
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
				}else{
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
				}
            }
        }else{
            foreach ($encabezado as $campo){
                $col=$col+1;
				if(count($encabezado)==$col){
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
				}else{
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
				}
            }
        }
        $tabla .= "</tr></thead><tbody>";
		for($i=0;$i<count($datos)-1;$i++)
		{   $tabla .= "<tr>";
			$c=0;
            foreach ($datos[$i] as $campo=>$valor)
			{   if( ($c==1) || ($c==7) || ($c==8)) 
					$tabla .= "<td style=\"text-align:center;\">".$valor."</td>";
				else
					$tabla .= "<td style=\"text-align:right;\">".$valor."</td>";
				$c++;
            }
			if(count($opciones)>0)
			{   $tabla .="<td>";
				foreach ($opciones[0] as $campo => $valor){
					$tabla .= str_replace('{codigo}',$datos[$i][$pref],$valor);
            	}
				$tabla .="</td>";
			}
            $tabla .= "</tr>";
		}
        $tabla .= "</tbody></table>";
        return $tabla;
    }
	static function tablaInputsencilla($datos = array(), $encabezado = array(), $id, $class, $opciones=array(),$pref){
        $opt = null;
        /*foreach($optional as $key => $value){
            $opt .= $key . "=" . $value . " ";
        }*/
        $tabla = "<table class='$class' id='$id'>";
        // Encabezado
        $tabla .= "<thead><tr>";
		$col=0;
        if(count($encabezado)<=0){
			
            foreach ($datos[0] as $campo=>$valor){
                $col=$col+1;
				if(count($encabezado)==$col){
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\" colspan='2'>".$campo."</th>";
				}else{
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\" colspan='2'>".$campo."</th>";
				}
            }
        }else{
            foreach ($encabezado as $campo){
                $col=$col+1;
				if(count($encabezado)==$col){
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\" colspan='2'>".$campo."</th>";
				}else{
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\" colspan='2'>".$campo."</th>";
				}
            }
        }
        $tabla .= "</tr></thead><tbody>";
        // Datos
		
		for($i=0;$i<count($datos)-1;$i++){
			$tabla .= "<tr>";
			
			
           
					 $tabla .= "<td>".$datos[$i]['nombre']."</td>";
				
			
			
			$tabla .= "<td><input id='banco_".$datos[$i]['codigo']."' type='text' class='' onkeyup='SumarColumna()' placeholder='$0.00' />";
			$tabla .= " <script type='text/javascript' charset='utf-8'>";
			$tabla .= '$(function() {$("#banco_'.$datos[$i]['codigo'].'").maskMoney({thousands:"", decimal:".", allowZero:false});});';
			$tabla .="</script>";
            $tabla .= "</td></tr>";
		}
        $tabla .= "</tbody></table>";
        return $tabla;
    }

	
    /*
     * Genera una tabla html deacuerdo a los datos provistos por parametros
     * @static
     * @param array $datos Datos a mostrar dentro de la tabla.
     * @param array $encabezado Fila a mostrar de encabezado de la tabla.
     * @para array $optional Atributos extras a incluir dentro de la tabla.
     * @return string Codigo HTML de la tabla formateada.
     */
    static function table_anidada($datos = array(), $encabezado = array(), $id, $class, $opciones=array(),$pref, $tablaAnidada=false ){
        $opt = null;
        /*foreach($optional as $key => $value){
            $opt .= $key . "=" . $value . " ";
        }*/
        $tabla = "<table class='$class' id='$id'>";
        // Encabezado
        $tabla .= "<thead><tr>";
        $tabla .= ($tablaAnidada? "<th style=\"text-align:center;vertical-align:middle\"></th>" : "<th style=\"text-align:center;vertical-align:middle\"></th>"); // Para la columna del botón que muestra/oculta la tabla anidada
        $col=0;
        if(count($encabezado)<=0){
            
            foreach ($datos[0] as $campo=>$valor){
                $col=$col+1;
                if(count($encabezado)==$col){
                    $tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>";
                }else{
                    $tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
                }
            }
        }else{
            foreach ($encabezado as $campo){
                $col=$col+1;

                if(count($encabezado)==$col){
                    $tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>";
                }else{
                    $tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
                }
            }
        }
        $tabla .= "</tr></thead><tbody>";
        // Datos
        
        for($i=0;$i<count($datos)-1;$i++){
            $tabla .= "<tr>";
            
            $tabla .= ($tablaAnidada? "<td class='details-control'></td>" : "<td class='details-control'><i style='color:green;' class='fa fa-plus-circle'></i></td>"); // Para la columna del botón que muestra/oculta la tabla anidada

            foreach ($datos[$i] as $campo=>$valor){
                $tabla .= "<td>".$valor."</td>";
            }
            if(count($opciones)>0){
                $tabla .="<td>";
                foreach ($opciones[0] as $campo => $valor){
                    $tabla .= str_replace('{codigo}',$datos[$i][$pref],$valor);
                }
                $tabla .="</td>";
            }
            
            $tabla .= "</tr>";
        }
        $tabla .= "</tbody></table>";
        return $tabla;
    }

    static function table($datos = array(), $encabezado = array(), $id, $class, $opciones=array(),$pref){
        $opt = null;
        /*foreach($optional as $key => $value){
            $opt .= $key . "=" . $value . " ";
        }*/
        $tabla = "<table class='$class' id='$id'>";
        // Encabezado
        $tabla .= "<thead><tr>";
		$col=0;
        if(count($encabezado)<=0){
			
            foreach ($datos[0] as $campo=>$valor){
                $col=$col+1;
				if(count($encabezado)==$col){
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
				}else{
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
				}
            }
        }else{
            foreach ($encabezado as $campo){
                $col=$col+1;
				if(count($encabezado)==$col){
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
				}else{
					$tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
				}
            }
        }
        $tabla .= "</tr></thead><tbody>";
        // Datos
		
		for($i=0;$i<count($datos)-1;$i++){
			$tabla .= "<tr>";
			
            foreach ($datos[$i] as $campo=>$valor){
                $tabla .= "<td>".$valor."</td>";
            }
			if(count($opciones)>0){
				$tabla .="<td>";
				foreach ($opciones[0] as $campo => $valor){
					$tabla .= str_replace('{codigo}',$datos[$i][$pref],$valor);
            	}
				$tabla .="</td>";
			}
			
            $tabla .= "</tr>";
		}
        $tabla .= "</tbody></table>";
        return $tabla;
    }

	static function tableArrayIn($datos = array(), $encabezado = array(), $id, $class, $opciones=array(), $tablaAnidada=false)
	{	$tabla = "<table class='$class' id='$id'>";
		// Encabezado
		$Encabezado="";
		$tabla .= "<thead><tr>";
		$tabla .= ($tablaAnidada? "<th style=\"text-align:center;vertical-align:middle\"></th>" : ""); // Para la columna del botón que muestra/oculta la tabla anidada
		$col=0;
		if(count($encabezado)<=0)
		{	foreach ($datos[0] as $campo=>$valor)
			{	$col=$col+1;
				if(count($encabezado)<=$col)
				{	$Encabezado.= "<th style=\"text-align:center;vertical-align:middle\">".$campo[0]."</th>";
				}else
				{	$Encabezado.= "<th style=\"text-align:center;vertical-align:middle\">".$campo[0]."</th>";
				}
			}
		}else
		{	foreach ($encabezado as $campo)
			{	$col=$col+1;
				if(count($encabezado)<=$col)
				{	$Encabezado.= "<th style=\"text-align:center;vertical-align:middle\">".$campo[0]."</th>";
				}else
				{	$Encabezado.= "<th style=\"text-align:center;vertical-align:middle\">".$campo[0]."</th>";
				}
			}
		}
		$tabla.= $Encabezado;
		$tabla .= "</tr></thead><tbody>";
		// Datos
		for($i=0;$i<count($datos)-1;$i++)
		{	$tabla .= "<tr>";
			$col=0;
            foreach ($datos[$i] as $campo=>$valor){
               $col=$col+1;
			   if($col>1){
			    $tabla .= "<td>".$valor."</td>";
			   }
            }
			if(count($opciones)>0){
				$tabla .="<td>";
				foreach ($opciones[0] as $campo => $valor){
					$tabla .= str_replace('{codigo}',$datos[$i][$pref],$valor);
            	}
				$tabla .="</td>";
			}
			
            $tabla .= "</tr>";
		}
        $tabla .= "</tbody>";
		$tabla .= "<tfoot>".$Encabezado."</tfoot>";
		$tabla .= "</table>";
      return $tabla;
	}
    static function tableVisor($datos = array(), $encabezado = array(), $id, $class, $opciones=array(), $tablaAnidada=false){
      $tabla = "<table class='$class' id='$id'>";
      // Encabezado
      $tabla .= "<thead><tr>";
      $tabla .= ($tablaAnidada? "<th style=\"text-align:center;vertical-align:middle\"></th>" : ""); // Para la columna del botón que muestra/oculta la tabla anidada
      $col=0;
      if(count($encabezado)<=0){
          
          foreach ($datos[0] as $campo=>$valor){
              $col=$col+1;
              if(count($encabezado)==$col){
                  $tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>";
              }else{
                  $tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
              }
          }
      }else{
          foreach ($encabezado as $campo){
              $col=$col+1;

              if(count($encabezado)==$col){
                  $tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>";
              }else{
                  $tabla .= "<th style=\"text-align:center;vertical-align:middle\">".$campo."</th>";
              }
          }
      }
      $tabla .= "</tr></thead><tbody>";
      // Datos
      for($i=0;$i<count($datos)-1;$i++){
          $tabla .= "<tr>";
          
          $tabla .= ($tablaAnidada? "<td class='details-control'></td>" : ""); // Para la columna del botón que muestra/oculta la tabla anidada

          foreach ($datos[$i] as $campo=>$valor){
              $tabla .= "<td>".$valor."</td>";
          }
          //var_dump($opciones);
          if(count($opciones)>0){
              $tabla .="<td>";
              foreach ($opciones[0] as $campo => $valor){
                $tabla .= str_replace('{codigo}', $datos[$i]["codigoFactura"], $valor);
                $tabla = str_replace('{numeroIdentificacion}', $datos[$i]["numeroIdentificacion"], $tabla); 
                $tabla = str_replace('{archivoPDF}', "FAC".$datos[$i]["prefijoSucursal"]."-".$datos[$i]["prefijoPuntoVenta"]."-".$datos[$i]["numeroFactura"].".pdf", $tabla);
                $tabla = str_replace('{archivoXML}', "FAC".$datos[$i]["prefijoSucursal"]."-".$datos[$i]["prefijoPuntoVenta"]."-".$datos[$i]["numeroFactura"].".xml", $tabla);
              }
              $tabla .="</td>";
          }
          
          $tabla .= "</tr>";
      }
      $tabla .= "</tbody></table>";
      return $tabla;
    }



    /*
     * Genera un salto de linea html.
     * @static
     * @param integer $length Total de saltos de linea a imprimir.
     * @return string Codigo HTML de los saltos de linea formateados.
     */
    static function br($length=1){
        $br = "";
        for($i=0; $i<$length; $i++){
            $br .= "<br>";
        }
        return $br;
    }
    /*
     * Genera una lista html.
     * @static
     * @param array $LIcontent Conjuntos de los elementos LI a agregar.
     * @para array $optional Atributos extras a incluir dentro de la lista.
     * @return string Codigo HTML de la lista formateada.
     */
    static function ul($LIcontent = array(), $optional = array()){
        $opt = "";
        foreach($optional as $key => $value){
            $opt .= $key . "=" . $value . "";
        }

        $ul = "<ul $opt>";
        foreach($LIcontent as $content){
            $ul .= "<li>".$content."</li>";
        }
        $ul .= "</ul>";
        return $ul;
    }
    /*
     * Genera un elemento contenedor (div).
     * @static
     * @param string $content Contenido del Div a mostrar.
     * @para array $optional Atributos extras a incluir dentro del bloque.
     * @return string Codigo HTML del div formateado.
     */
    static function div($content = "&nbsp;", $optional = array())
	{	$opt = "";
        foreach($optional as $key => $value)
		{	$opt .= $key . "=" . $value . " ";
        }
        return "<div ".$opt.">".$content."</div>";
    }
	static function select($options = array(), $optional = array(),$valor_selected)
	{	$opt = "";
        foreach($optional as $key => $value){
            $opt .= $key . "=" . $value . " ";
        }
        $select = "<select $opt>";	
		for($i=0;$i<count($options)-1;$i++){
			if(trim($options[$i][0])==trim($valor_selected)){
				$sel="selected='selected'";
			}else{
				$sel="";
			}
			$select .= "<option value='".$options[$i][0]."'". $sel." >".$options[$i][1]."</option>";
        }
        $select .= "</select>";
        return utf8_encode($select);
    }
    static function input($valor = "", $optional = array()){
        $opt = "";
        foreach($optional as $key => $value){
            $opt .= $key . "='" . $value . "'";
        }

        return "<input value='$valor' $opt />";
    }
	
	static function checkListBox($elementos=array(), $campoVisualizacion='', $campoValor='', $seleccionados=array(), $funcion=""){
        $checkListBox = "";
        for($i=0;$i<count($elementos)-1;$i++){
			$checkListBox .= "<label><input type='checkbox' id='check_".$elementos[$i][$campoValor]."' name='check_".$elementos[$i][$campoValor]."' value='".$elementos[$i][$campoValor]."' ";
			foreach ($seleccionados as $valor) {
                if($valor == $elementos[$i][$campoValor]){ $checkListBox .= "checked='checked'" ; }
            }
            if($funcion!=''){ $checkListBox.= " onchange='".str_replace('{codigo}', $elementos[$i][$campoValor], $funcion)."'"; }
            $checkListBox .= " /> ".$elementos[$i][$campoVisualizacion]."<div id='div_check_".$elementos[$i][$campoValor]."'></div></label>";
		}
		//foreach ($elementos as $elemento) {}
        return $checkListBox;
    }
	
	static function barChart($datos=array(),$label,$contenedor)
	{
		$graphic = "";$labels = "";$data = "";
		for($i=0;$i<count($datos);$i++)
		{	$labels .= "'".$datos[$i][1]."',";
			$data 	.= "'".$datos[$i][0]."',";
        }
		$labels = trim($labels,",");
		$data 	= trim($data,",");
		$graphic = "$(function (){ var barData = { ";
		$graphic.= "labels: [".$labels."],";
		$graphic.= "datasets: [{label:'".$label."',fillColor: 'rgba(100, 214, 222, 1)',";
		$graphic.= "strokeColor: 'rgba(120, 214, 222, 1)',";
		$graphic.= "pointColor: 'rgba(210, 214, 222, 1)',";
		$graphic.= "pointStrokeColor: '#c1c7d1',";
		$graphic.= "pointHighlightFill: '#fff',";
		$graphic.= "pointHighlightStroke: 'rgba(220,220,220,1)',";
		$graphic.= "data:[".$data."]";
		$graphic.= "}]};";
		$graphic.= "var barChartCanvas = $('#".$contenedor."').get(0).getContext('2d');";
        $graphic.= "var barChart = new Chart(barChartCanvas);";
		$graphic.= "var barChartOptions = {";
		$graphic.= "scaleBeginAtZero: true,";
		$graphic.= "scaleShowGridLines: true,";
		$graphic.= "scaleGridLineColor: 'rgba(0,0,0,.05)',";
		$graphic.= "scaleGridLineWidth: 1,";
		$graphic.= "scaleShowHorizontalLines: true,";
		$graphic.= "scaleShowVerticalLines: true,";
		$graphic.= "barShowStroke: true,";
		$graphic.= "barStrokeWidth: 2,";
		$graphic.= "barValueSpacing: 5,";
		$graphic.= "barDatasetSpacing: 1,";
		$graphic.= "legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',";
		$graphic.= "responsive: true,";
		$graphic.= "maintainAspectRatio: true";
		$graphic.= "};";
		$graphic.= "barChartOptions.datasetFill = false;";
        $graphic.= "barChart.Bar(barData, barChartOptions);";
		$graphic.= "});";
		return utf8_encode($graphic);
	}
	static function pieChart($datos=array(),$contenedor)
	{	$color[0]= "#FF8C00";
		$color[1]= "#FFA500";
		$color[2]= "#FFD700";
		$color[3]= "#B8860B";
		$color[4]= "#DAA520";
		$color[5]= "#808000";
		$color[6]= "#FFFF00";
		$color[7]= "#9ACD32";
		$color[8]= "#556B2F";
		$color[9]= "#6B8E23";
		$color[10]= "#7CFC00";
		$color[11]= "#ADFF2F";
		$graphic = "";$data = "";$r="";$g="";$b="";
		for($i=0;$i<count($datos);$i++)
		{	/*$hex = "";
			foreach(array('r', 'g', 'b') as $color)
			{	$val = mt_rand(0, 255);
				$dechex = dechex($val);
				if(strlen($dechex) < 2)
				{	$dechex = "0" . $dechex;
				}
				$hex .= $dechex;
			}*/
			$data .= "{value:".$datos[$i][0].",color:'".$color[$i]."',highlight:'".$color[$i]."',label:'".$datos[$i][1]."'},";
        }
		$data 	= trim($data,",");
		$graphic.= "$(function (){";
		$graphic.= "var pieChartCanvas = $('#".$contenedor."').get(0).getContext('2d');";
        $graphic.= "var pieChart = new Chart(pieChartCanvas);";
		$graphic.= "var pieData = [".$data."];";
		$graphic.= "var pieOptions = {";
        $graphic.= "segmentShowStroke: true,";
        $graphic.= "segmentStrokeColor: '#fff',";
        $graphic.= "segmentStrokeWidth: 2,";
        $graphic.= "percentageInnerCutout: 50,";
        $graphic.= "animationSteps: 100,";
        $graphic.= "animationEasing: 'easeOutBounce',";
        $graphic.= "animateRotate: true,";
        $graphic.= "animateScale: false,";
        $graphic.= "responsive: true,";
        $graphic.= "maintainAspectRatio: true,";
        $graphic.= "legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'";
        $graphic.= "};";
        $graphic.= "pieChart.Doughnut(pieData, pieOptions);";
		$graphic.= "});";
		return utf8_encode($graphic);
	}
	static function lineChart($datos=array(),$label,$contenedor)
	{
		$graphic = "";$labels = "";$data = "";
		for($i=0;$i<count($datos);$i++)
		{	$labels .= "'".$datos[$i][1]."',";
			$data 	.= "'".$datos[$i][0]."',";
        }
		$labels = trim($labels,",");
		$data 	= trim($data,",");
		$graphic.="var data = {";
		$graphic.="labels: [".$labels."],";
		$graphic.="datasets: [";
        $graphic.="{";
        $graphic.="label: '".$label."',";
        $graphic.="fill: false,";
        $graphic.="lineTension: 0.1,";
        $graphic.="backgroundColor: 'rgba(204,192,192,0.4)',";
        $graphic.="borderColor: 'rgba(75,192,192,1)',";
        $graphic.="borderCapStyle: 'butt',";
        $graphic.="borderDash: [],";
        $graphic.="borderDashOffset: 0.0,";
        $graphic.="borderJoinStyle: 'miter',";
        $graphic.="pointBorderColor: 'rgba(75,192,192,1)',";
        $graphic.="pointBackgroundColor: '#fff',";
        $graphic.="pointBorderWidth: 1,";
        $graphic.="pointHoverRadius: 5,";
        $graphic.="pointHoverBackgroundColor: 'rgba(75,192,192,1)',";
        $graphic.="pointHoverBorderColor: 'rgba(220,220,220,1)',";
        $graphic.="pointHoverBorderWidth: 2,";
        $graphic.="pointRadius: 1,";
        $graphic.="pointHitRadius: 10,";
        $graphic.="data: [".$data."],";
        $graphic.="}]};";
		$graphic.= "var lineChartCanvas = $('#".$contenedor."').get(0).getContext('2d');";
        $graphic.= "var lineChart = new Chart(lineChartCanvas);";
		$graphic.= "var lineChartOptions = {";
		$graphic.= "};";
        $graphic.= "lineChart.Line(data, lineChartOptions);";
		return utf8_encode($graphic);
	}
}
?>
