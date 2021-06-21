<?php
/**
 * Soortcodes for fetch of information from mit.enhedslisten.dk
 * Copyritht Enhedslisten og  Palle Lollk
 *
 * 2019-02-18	Palle Lolk	Module created.
 * 2019-05-21	Palle Lolk	Interface to web first version.
 * 2019-05-28	Palle Lolk	Search string right and left tremmind.
 * 2019-06-25	Palle Lolk	Unit name shown for person entries.
 * 				Email and tlf for sections added.
 * 2021-03-23	Palle Lolk	function list_networks: condition $pos < 2 added.
 *				function show_afdeling: new lines replaced by br
 *
 */

function odoo_section_contact_function($atts) {
	$mydb = new wpdb('c2telefonbog','tl6bwsS-Txr581lpIG4','c2omdel','v0062.dotserv.com');
	   
	$count = extract(shortcode_atts(array( 'section' => 'xyz', ), $atts));
	
	if (strcmp($section, 'xyz') == 0) {
		$section = get_bloginfo( '', 'display' );
	}

	$query = 'SELECT * FROM elprod WHERE Enhedsnavn = "' . $section . '" AND profil = 68 order by Kommune, Navn';
	$result = $wpdb->get_results($query);
	$count1 = count($result);
   //	$len = strlen($section);
	if ($count1 == 0) {
		$return_string  = 'Ukendt afdeling: ' . $section;
	} else {
   //		$return_string = '<h1>' . $count . '</h1>';
   //		$return_string  = '<h1>' . $count1 . ' len = ' . $len . '</h1>';
   //		$return_string .= '<h2>' . 'section = "' . $section . '"</h2>';
   //		$return_string .= '<h3>' . get_bloginfo( '', 'display' ) . ' get_bloginfo() ' . $query .'</h3>';
		$return_string  = 'Kontaktperson:';
		$return_string .= '<br>' . $result[0]->Navn;
		$return_string .= '<br>Tlf: ' . $result[0]->Tlf;
		$return_string .= '<br> Email: ' . $result[0]->Email;
	}
	return $return_string;
}

add_shortcode('section_contact_mit_el', 'odoo_section_contact_function');


function get_lu_home_page($beskrivelse) {
		$luer = array(	'Medlem af Amager Vest Lokaludvalg' => 'http://www.avlu.dk/',
					'Medlem af Amager Øst Lokaludvalg'  => 'http://www.xn--alu-0na.dk/',
					'Medlem af Brønshøj-Husum Lokaludvalg'  => 'http://www.broenshoej-husumlokaludvalg.kk.dk/',
					'Medlem af Christianshavns Lokaludvalg'  => 'http://www.christianshavnslokaludvalg.kk.dk/',
					'Medlem af Indre By Lokaludvalg'  => 'https://indrebylokaludvalg.kk.dk/',
					'Medlem af Nørrebro Lokaludvalg'  => 'http://noerrebrolokaludvalg.kk.dk/',
					'Medlem af Bispebjerg Lokaludvalg'  => 'http://www.bispebjerglokaludvalg.kk.dk/',
					'Medlem af Kgs. Enghave Lokaludvalg'  => 'http://www.kongensenghavelokaludvalg.kk.dk/',
					'Medlem af Valby Lokaludvalg'  => 'http://www.valbylokaludvalg.kk.dk/',
					'Medlem af Vanløse Lokaludvalg'  => 'http://www.vanloeselokaludvalg.kk.dk/',
					'Medlem af Vesterbro Lokaludvalg'  => 'http://www.vesterbrolokaludvalg.kk.dk/',
					'Medlem af Østerbro Lokaludvalg'  => 'http://www.oesterbrolokaludvalg.kk.dk/',
					);
	$home_page = $luer[$beskrivelse];
	if ($home_page == null) {
		$home_page = '';
	}
	return($home_page);
}

function list_lu($my_db) {
	$result = $my_db->get_results('SELECT Beskrivelse, Navn, Tlf FROM elprod WHERE Profil = 101 AND Beskrivelse is not null order by Beskrivelse');
    	$return_string  = '';
	$return_string .= '<table border="1" style="border-style:solid; border-width:1">';
	$return_string .= '<col style="width:43%" />';
	$return_string .= '<col style="width:43%" />';
	$return_string .= '<col style="width:14%" />';

    foreach ( $result as $print )   {
		$beskr = $print->Beskrivelse;
		if (strlen($beskr) < 3) { continue; }
		$link = get_lu_home_page($beskr);
		$besk_with_link = '<a href="' . $link . '">' . $beskr . '</a>';
		$return_string .= '<tr>';
        	$return_string .= '<td style="border-style:solid">' . $besk_with_link . '</td>';
        	$return_string .= '<td style="border-style:solid">' . $print->Navn . '</td>';
        	$return_string .= '<td style="border-style:solid">' . $print->Tlf .'</td>';
		$return_string .= '</tr> ';
    }

	$return_string .= '</table>';
	return $return_string;
}

/**
 * Returns a list contact persons of the copenhagen sections
 *
 * @atts array of attribute values
 * @return a list contact persons of the copenhagen sections
 */
function list_kontakter($db, $show)  {
	$return_string  = '';

	if (strcmp($show, 'empty') == 0) {
		$sections = get_bloginfo( '', 'display' );
	} else {
		$sections = str_replace(", ", ",", $show);
		$sections = str_replace(", ", ",", $sections);
		$sections = str_replace(",", '","', $sections);
	}

	//$return_string .= '<h1>' . $sections . '</h1>';
	
	$query = 'SELECT * FROM elprod WHERE Enhedsnavn IN ("' . $sections . '") AND Profil in (68,87,96) order by Enhedsnavn';

	
	// Just during test
	//$return_string  = '<h1>' . "Before sections_contact shortcode." . '</h1>';
	//$return_string .= '<h1>' . $sections . '</h1>';
	//$return_string .= '<h1>' . $query . '</h1>';
	//$return_string .= '<h1>' . "After sections_contact shortcode." . '</h1>';

	$result = $db->get_results($query);
	$count1 = count($result);

   //	$return_string .= $count1 . "<br>";
	$not_first = false;
   //	$len = strlen($section);
	if ($count1 == 0) {
		$return_string  .= 'Ingen fundet<br>';
	} else {
		foreach ( $result as $print )   {

			if ($not_first) {
				$return_string .= '<br>';
			} else {
				$not_first = true;
			}
			
			$section = $print->Enhedsnavn;
			$navn = $print->Navn;
			$email = "E-mail: " . $print->Email;
			//$return_string .= "not_first = " . $not_first . ", " . $section . ", " . $navn . "<br>";;
			$query1 = 'SELECT Hjemmeside FROM elprod WHERE Enhedstype in (5,7,8) and Enhedsnavn = "' . $section . '"';
			$result1 = $db->get_results($query1);
			if (count($result1) > 0) {
				$section_site = $result1[0]->Hjemmeside;
			}
			
			if (($section_site != null) && (strlen($section_site)> 0)) {
				$return_string .= '<a href="//' . $section_site . '"><strong>' . $section . '</strong></a>';
			} else {
				$return_string .= '<strong>' . $section . '</strong>';
			}
			$return_string .= '<br>' . $navn;
			$return_string .= '<br>' . $email . '<br>';

		}
    }
   /*
	$return_string .= "list_kontakter<br>";
   */
	return $return_string;
}

//add_shortcode('sections_contact', 'sections_contact_function');

/**
 * Returns a list of board members of a given unit
 *
 * @atts array of attribute values
 * @return a list of board members
 */
function board_function($atts) {
	global $wpdb;
	   
	$count = extract(shortcode_atts(array( 'section' => 'empty', ), $atts));
	
	if (strcmp($section, 'empty') == 0) {
		$section = get_bloginfo( '', 'display' );
	}
	
	$query = 'SELECT * FROM wp_sheet1 WHERE Enhedsnavn = "' . $section . '" AND STRCMP(Beskrivelse, "Bestyrelsesmedlem") = 0 order by Navn';

	$return_string  = '';
	
	// Just during test
	//$return_string  = '<h1>' . "Before sections_contact shortcode." . '</h1>';
	//$return_string .= '<h1>' . $sections . '</h1>';
	//$return_string .= '<h1>' . $query . '</h1>';
	//$return_string .= '<h1>' . "After sections_contact shortcode." . '</h1>';

	$result = $wpdb->get_results($query);
	$count1 = count($result);
	
	$not_first = false;
   //	$len = strlen($section);
	if ($count1 == 0) {
		$return_string  .= 'Ingen bestyrelsesmedlemmer';
	} else {
		foreach ( $result as $print )   {
			if ($not_first) {
				$return_string .= '<br>';
			} else {
				$not_first = true;
			}
			$navn = $print->Navn;
			$email = "E-mail: " . $print->Email;
			$tlf = "Tlf.: " . $print->Tlf;
			
			$return_string .= $navn;
			$return_string .= '<br>' . $email;
			$return_string .= '<br>' . $tlf;
		}
    }

	return $return_string;
}

//add_shortcode('board', 'board_function');

function tab_part($arr) {
	$return_string = "";
	$return_string  .= '<div class="tabodoo1"><table><tbody>';
	$siz = count($arr);
	if ($siz > 0) {
		for ($i=0; $i<$siz; $i++) {
			$first = ($i % 4) ==  0;
			$lastst = ($i % 4) ==  3;
			if ($first) {
				$return_string .= '<tr>';
			}
			$return_string .= '<td>' . $arr[$i] . '</td>';
			if ($last) {
				$return_string .= '</tr>';
			}
		}
		$i = $siz;
		if (($i % 4) > 0) {
			while (($i++ % 4) > 0) {
				$return_string .= '<td></td>';
			}
			$return_string .= '</tr>';
		}
	}
	$return_string  .= '</tbody></table></div>';


	return $return_string;
}

function  search_field($text) {
	if (($text != null) && (strlen($text)> 0)) {
		$stext = $text;
	} else {
		$stext = "Søgning";
	}
	$return_string = "";
	$return_string .= '<div><div><form action="/telefonbog/">'
   //			. '<div style="display:inline">'
			. ' <input type="text" id="odoo-telefonbog" name="text" value="' 
			. $stext  
			. '"  maxlength="128" style="margin:0px;float:left;width:60%"/>'
			. '<input type="submit" value="Søg" style="margin:0px;" />'
   //			. '</div>'
			. '</form></div></div>';
   //	echo $return_string;
   //	$return_string = "";
	return $return_string;
}

function list_afdelinger($db, $skip) {
	$skip_name = $skip == "empty" ? "'xxxxx'" : $skip;
	$query = "SELECT * FROM elprod WHERE Enhedstype = 5 AND Enhedsnavn NOT IN (" . $skip_name . ") order by Enhedsnavn";
   $result = $db->get_results($query);
   
   

	$count1 = count($result);
	$return_string = "";
	
	$not_first = false;
	if ($count1 == 0) {
		$return_string  .= 'Ingen afdelinger';
	} else {
      $return_string  .= ' 
      <script>
      function filterAfd(val){
         console.log("yup");
         val = val.toUpperCase();
         let flipBoxes = document.getElementsByClassName("flipBox");
       
           Array.prototype.forEach.call(flipBoxes, child => {
             let id = child.id.toUpperCase()
             if(!id.includes(val))
               child.style.display = "none";
             else{
               child.style.display = "block";
             }
       });
       }
      
      </script>
      <input type="text" id="filterInput" placeholder="Find afdeling..." oninput="filterAfd(this.value)">
      
      <div class="flipBox_container">';
		$res_array = array();
		foreach ( $result as $print )   {
         
        
         
         $section = $print->Enhedsnavn;
			$pos = strpos($section, "-");
			if (($pos !== false) && ($pos < 2)) continue;
			
			$section_site = 'vores.enhedslisten.dk/kontakt/?afd=' . $section;
        /*  $res = '<a href="//' . $section_site . '"><strong>' . $section . '</strong></a>'.'øf øf'.$print->Email ; */
        //$nr = $print->Løbenummer;
        
        $allValues = get_local_info($section);
         //$phoneNum = get_phone($section);
         //$desc = get_desc($section);
         //print_r($allValues);

         $contPers = $allValues['contPers'];

         $phoneNum = $allValues['phoneNum'];
         if($phoneNum != ''){
            $phoneNum = '<p>'.$phoneNum.'</p>';
         }
         
         $fb = $allValues['fb'];
         if($fb != ''){
            $fb = '<a class="fbLink icon_facebook_white_small" target="_blank" href="'.$fb.'"></a>';
         }

         $hp = $allValues['hp'];
         if($hp != ''){
               $hp = '<a class="hpLink icon_homepage_white_small" target="_blank" href="'.$hp.'"></a>';
         }

         $desc = $allValues['desc'];
         if($desc != ''){
            $desc = '<p class="flipBox_desc">'.$desc.'</p>';
         }

         $mail =  $allValues['mail'];
         if($mail != ''){ 
			$mailAdr = $mail;
            $mail = '<a class="hpLink icon_mail_white_small" target="_blank" href="mailto:'.$mailAdr.'"></a>';
			$mailTxt = '<p><a target="_blank" href="mailto:'.$mailAdr.'">'.$mailAdr.'</a></p>';
         }

         $afdName = $allValues['afdName'];
         
         $id = preg_replace('/\s+/', '_', $afdName);

         $res = 
            '<div class="flipBox" id="'.$id.'">
               <div class="flipBox_front"><h5>'.$afdName.'</h5></div>
               <div class="flipBox_back">
                  <div class="flipBox_content">
                     <h5>'.$afdName.'</h5>'.$desc.'<br><p class="p-small">Kontaktperson:</p><h6>'.$contPers.'</h6>'.$phoneNum.$mailTxt.
                     '</div>
                  <div class="flipBox_links">'.$fb.$mail.$hp.'</div>
               </div>
            </div>';


			array_push($res_array, $res);
         $return_string .= $res;
         
		}
      $return_string  .= 
            '<div class="spacer"></div>
            <div class="spacer"></div>
            <div class="spacer"></div>
            <div class="spacer"></div>
            <div class="spacer"></div>
            <div class="spacer"></div>
            <div class="spacer"></div>
         </div>';
		//print_r($result);
    	}
       
	return $return_string;
}


function list_udvalg($db, $skip) {
	$skip_name = $skip == "empty" ? "'xxxxx'" : $skip;
	$query = "SELECT * FROM elprod WHERE Enhedstype = 7 AND Enhedsnavn NOT IN (" . $skip_name . ") order by Enhedsnavn";
	$result = $db->get_results($query);
	$count1 = count($result);
	$return_string = "";
	// $return_string  .= $count1 . ", " . $query . "<br>";
	
	$not_first = false;
   //	$len = strlen($section);
	if ($count1 == 0) {
		$return_string  .= 'Ingen udvalg';
	} else {
		foreach ( $result as $print )   {
			$section = $print->Enhedsnavn;
			$pos = strpos($section, "-");
			// $return_string  .= $pos . ", " . $section . "<br>";
			if (($pos !== false) && ($pos < 2)) continue;
			if ($not_first) {
				$return_string .= '<br>';
			} else {
				$not_first = true;
			}
			$section_site = 'vores.enhedslisten.dk/kontakt/?afd=' . $section;
			$return_string .= '<a href="//' . $section_site . '"><strong>' . $section . '</strong></a>';
		}
    }

	return $return_string;
}


function list_networks($db) {
	$query = 'SELECT * FROM elprod WHERE Enhedstype = 8 order by Enhedsnavn';
	$result = $db->get_results($query);
	$count1 = count($result);
	$return_string = "";
	
	$not_first = false;
   //	$len = strlen($section);
	if ($count1 == 0) {
		$return_string  .= 'Ingen afdelinger';
	} else {
		foreach ( $result as $print )   {
			$section = $print->Enhedsnavn;
			$pos = strpos($section, "-");
			if (($pos !== false) && ($pos < 2)) continue;
			if ($not_first) {
				$return_string .= '<br>';
			} else {
				$not_first = true;
			}
			$section_site = 'vores.enhedslisten.dk/kontakt/?afd=' . $section;
			$return_string .= '<a href="//' . $section_site . '"><strong>' . $section . '</strong></a>';
		}
    }

	return $return_string;
}



function list_ansatte($db, $skip) {
	$query = "SELECT * FROM elprod WHERE (profil = 93 OR profil = 123) AND Enhedsnavn NOT IN (" . $skip . ") order by Enhedsnavn, Navn";
	$result = $db->get_results($query);
	$count1 = count($result);
	$return_string = "";
   //	$return_string = "Skip=" . $skip . "<br>";
   //	$return_string = $query . "<br>";
	
	$not_first = false;
   //	$len = strlen($section);
	if ($count1 == 0) {
		$return_string  .= 'Ingen ansatte';
	} else {
		$gl_lokalitet = " ";
		$lokalitet = "";
		foreach ( $result as $ansat )   {
			$lokalitet = $ansat->Enhedsnavn;
			if ($lokalitet != $gl_lokalitet) {
				$return_string .= '<h2>' . $lokalitet . "</h2>";
				$gl_lokalitet = $lokalitet;
			}
			$return_string .= "<strong>" . $ansat->Navn . "</strong><br>";
			$besk = $ansat->Beskrivelse;
			if (($besk != null) && (strlen($besk)> 0)) {
				$return_string .=  $besk . '<br>';
			}
			$return_string .= contact_inf($ansat);
			$return_string .= '<br>';
		}
    }

	return $return_string;
}

function get_lokalitet($person) {
	$profil = $person->Profil;
	$return_string = "";
	$lokalitet = $person->Enhedsnavn;
	switch ($profil) {
		case 64: $head = "EL Folketingsmedlem";
			$lokalitet = "";
			break;
		case 65: $head = "EL Spidskandidat til folketingsvalg";
			$lokalitet = "";
			break;
		case 66: $head = "EL Folketingskandidat";
			$lokalitet = "";
			break;
		case 68: $head = "EL Afdelingkontakt";
			break;
		case 69: $head = "EL Regionskontakt";
			break;
		case 87: $head = "EL Netværkskontakt";
			break;
		case 93: $head = "EL Ansat";
			break;
		case 96: $head = "EL Udvalgskontakt";
			break;
		case 97: $head = "EL Kommunalbestyrelsesmedlem";
				$lokalitet = $person->Kommune;
			break;
		case 98: $head = "EL Regionsrådsmedlem";
			break;
		case 101: $head = "Lokaludvalgsmedlem (Kbh.)";
			$lokalitet = "";
			break;
		case 107: $head = "Kontaktperson";
			break;
		case 123: $head = "EL Lokalt Ansat";
			break;
		case 125: $head = "Kommunal post";
			break;
		case 138: $head = "EL Hovedbestyrelsesmedlem";
			break;
		case 139: $head = "EL Forretningsudvalgsmedlem";
			break;
		default: $head = "" . $profil;
				$lokalitet = "";
	}
		
	$return_string .= $head;
	if (strlen($lokalitet) > 0) {
		$return_string .= ", " . $lokalitet;
	}
	$return_string .= "<br>";

	return $return_string;
}

function person_inf($person, $descr = true, $bold_name = true, $what = false, $where = false) {
	
	$profil = $person->Profil;
	$return_string = "";
   //	$return_string .= "What = " . $what . "<br>";
   //	$return_string .= "Profil = " . $profil . "<br>";
	
	if ($what) {
		$return_string .= get_lokalitet($person);
	}
	
	$return_string .= $bold_name ? "<strong>" : "";
	$return_string .= $person->Navn;
	$return_string .= $bold_name ? "</strong>" : "";
	$return_string .=  "<br>";

	if ($where) {
		$section = $person->Enhedsnavn;
		if (($section != null) && (strlen($section) > 0)) {
			$return_string .=  $section . '<br>';
		}
	}
	
	$besk = $person->Beskrivelse;
	if (($besk != null) && (strlen($besk) > 0) && $descr) {
		$return_string .=  $besk . '<br>';
	}
	$return_string .= contact_inf($person);
	$return_string .= '<br>';
	return $return_string;
}

function unit_inf($unit, $what = true, $where = false) {
	$return_string = "";
	
	$section = $unit->Enhedsnavn;
	$unit_type = $unit->Enhedstype;
	$pos = strpos($section, "-");
   //	$return_string .= "Section = " . $section . ", Pos = " . $pos . "<br>";
	if (($pos !== false) && ($pos < 3)) return $return_string;
	$pos = strpos($section, "SUF");
   //	$return_string .= "Pos = " . $pos . "<br>";
	if (($pos !== false) && ($pos < 3)) return $return_string;
	$head = "";
	$link = false;
	if ($what) {
		switch ($unit_type) {
			case 5: $head = "EL Afdeling<br>";
				$link = true;
				break;
			case 6: $head = "EL Region<br>";
				break;
			case 7: $head = "EL Udvalg<br>";
				$link = true;
				break;
			case 9: $head = "EL Netværk<br>";
				$link = true;
				break;
			case 13: $head = "EL Overenhed<br>";
				break;
			case 15: $head = "EL Underafdelingbr>";
				break;
			case 16: $head = "EL Anden enhed<br>";
				break;
		}
		
		$return_string .= $head;
	}
	if ($link) {
		$section_site = 'localhost:81/wordpress/kontakt/?afd=' . $section;
		$return_string .= '<a href="//' . $section_site . '"><strong>' . $section . '</strong></a><br>';
	} else {
		$return_string .= '<strong>' . $section . '</strong><br>';
	}
	
	$email = $unit->Email;
	if (($email != null) && (strlen($email)> 0)) {
		$return_string .= 'E-mail: ' . $email . '<br>';
	}

	$facebook = $unit->Facebook;
	if (($facebook != null) && (strlen($facebook)> 0)) {
		$return_string .= 'Facebook:  <a href="' . $facebook . '">' . $facebook . '</a><br>';
	}
	
	$homepage = $unit->Hjemmeside;
	if (($homepage != null) && (strlen($homepage)> 0)) {
		$return_string .= 'Hjemmeside:  <a href="' . $homepage . '">' . $homepage . '</a><br>';
	}

	return $return_string;
}

function list_hbmedlem($db) {
	return list_hb($db, 138);
}

function list_hbfu($db) {
	return list_hb($db, 139);
}

function list_hb($db, $profile) {
	$query = "SELECT * FROM elprod WHERE profil = " . $profile . " AND Enhedsnavn IN ('hovedbestyrelsen') order by Navn";
	$result = $db->get_results($query);
	$count1 = count($result);
	$return_string = "";
   //	$return_string = "Skip=" . $skip . "<br>";
   //	$return_string = $query . "<br>";
	
	$not_first = false;
   //	$len = strlen($section);
	if ($count1 == 0) {
		$return_string  .= 'Ingen HB-medlemmer';
	} else {
		foreach ( $result as $medlem )   {
			$return_string .= person_inf($medlem, false);
		}
    }

	return $return_string;
}

function list_byraad($db, $profil) {
	$query = "SELECT * FROM elprod WHERE profil = " . $profil . " OR profil = 125 order by Kommune, Navn, Profil DESC";
	$result = $db->get_results($query);
	$count1 = count($result);
	$return_string = "";
   //	$return_string = $query . "<br>";
	
	$not_first = false;
   //	$len = strlen($section);
	if ($count1 == 0) {
		$return_string  .= 'Ingen byrødder<br>';
	} else {
		$gl_lokalitet = " ";
		$lokalitet = "";
		$gl_navn = " ";
		$navn = "";
		$new_line = false;
		foreach ( $result as $person )   {
			$lokalitet = $person->Kommune;
			if ($lokalitet != $gl_lokalitet) {
				if ($new_line) {
					$return_string .= '<br>';
				}
				$return_string .= '<h2>' . $lokalitet . "</h2>";
				$gl_lokalitet = $lokalitet;
				$gl_navn = " ";
				$new_line = false;
			}
			$navn =  $person->Navn;
			if ($navn != $gl_navn) {
				$gl_navn = $navn;
				if ($new_line) {
					$return_string .= '<br>';
				}
				$new_line = true;
				$return_string .= "<strong>" . $navn . "</strong><br>";
				$return_string .= contact_inf($person);
			}
			$besk = $person->Beskrivelse;
			if (($besk != null) && (strlen($besk)> 0)) {
				$return_string .=  $besk . '<br>';
			}
		}
	}

	return $return_string;
}

function list_regionsraad($db) {
	$query = "SELECT * FROM elprod WHERE profil = 98 order by Enhedsnavn, Navn";
	$result = $db->get_results($query);
	$count1 = count($result);
	$return_string = "";
   //	$return_string = $query . "<br>";
	
	$not_first = false;
   //	$len = strlen($section);
	if ($count1 == 0) {
		$return_string  .= ' Ingen regionsrødder<br>';
	} else {
		$gl_lokalitet = " ";
		$lokalitet = "";
		foreach ( $result as $person )   {
			$lokalitet = $person->Enhedsnavn;
			if ($lokalitet != $gl_lokalitet) {
				$return_string .= '<h2>' . $lokalitet . "</h2>";
				$gl_lokalitet = $lokalitet;
			}
			$return_string .= "<strong>" . $person->Navn . "</strong><br>";
			$besk = $person->Beskrivelse;
			if (($besk != null) && (strlen($besk)> 0)) {
				$return_string .=  $besk . '<br>';
			}
			$return_string .= contact_inf($person);
			$return_string .= '<br>';
		}
    }

	return $return_string;
}

function list_results($db, $search_string) {
	$trimmed_search_string = rtrim(ltrim($search_string));
	$query = 'SELECT * FROM elprod WHERE navn like "%' . $trimmed_search_string . '%" OR Beskrivelse like "%' . $trimmed_search_string . '%" OR Enhedsnavn like "%' . $trimmed_search_string . '%" OR Tlf like "%' . $trimmed_search_string . '%" order by Enhedsnavn, Navn, Profil DESC';
	$results = $db->get_results($query);
	$count = count($results);
	$return_string = "";
   //	$return_string .= $search_string . "<br>";
	$return_string .= search_field($search_string) . "<br><br><h3>Søgeresultater:</h3>";
   //	$return_string .= $query . "<br>";
   //	$return_string .= $count . "<br>";
   //	$return_string .= $search_string . "<br>";
	
	$not_first = false;
   //	$len = strlen($section);
	if ($count == 0) {
		$return_string  .= 'Der blev ikke fundet nogen resultater<br>';
	} elseif (strlen($search_string) < 2) { }
	else {
   //		$lokalitet = "";
		foreach ( $results as $result )   {
			$profil =  $result->Profil;
			$nprofil =  (int)$result->Profil;
			$enhedstype = $result->Enhedstype;
			$lokalitet = $result->Enhedsnavn;
			if (is_null($profil)) {
   //				$return_string .= "Lokalitet = " . $lokalitet . "<br>";
				if (($enhedstype >= 5 && $enhedstype <= 8 ) || ($enhedstype >= 12 && $enhedstype <= 16 )) {
					$return_string  .= '<div>';
					$return_string .= unit_inf($result);
					$return_string .= "<br>";
					$return_string  .= '</div>';
				}
			} else {
   //				$return_string .= "Profil = " . $nprofil . "<br>";
				if (($nprofil >= 1 && $nprofil <= 8 ) || ($nprofil >= 9 && $nprofil <= 200 )) {
   //					$return_string .= $result->Navn . "<br>";
					// what false at least for profile 98
					$return_string  .= '<div>';
					$return_string .= person_inf($result, true, true, true);
					$return_string  .= '</div>';
				}
			} 
		}
    }

    return $return_string;
}

function spaces($name) {
	$result = str_replace("%20", " ", $name);
		return $result;
}

function contact_inf($record) {
	$return_string = '';
	$tlf = $record->Tlf;
	if (($tlf != null) && (strlen($tlf)> 0)) {
		$return_string .= 'Tlf: ' . $tlf . '<br>';
	}
	$email = $record->Email;
	if (($email != null) && (strlen($email)> 0)) {
		$return_string .= 'E-mail: <a href="mailto:' . $email . '">' . $email . '</a><br>';
	}
	return $return_string;
}

function contact_inf_phone($record) {
	$return_string = '';
	$tlf = $record->Tlf;
	if (($tlf != null) && (strlen($tlf)> 0)) {
		$return_string .= 'Tlf: ' . $tlf;
	}
	
	return $return_string;
}

function show_afdeling($db, $afd_navn) {
   
   $enhedsnavn = spaces($afd_navn);
	$query = 'SELECT * FROM elprod WHERE Enhedsnavn = "' . $enhedsnavn . '"  ORDER BY Enhedstype DESC, Profil';
	$result = $db->get_results($query);
	$count1 = count($result);
	$return_string = "";
	//$return_string .= $query . "; " . $count1 . "<br>";
	
	$type = $result[0]->Enhedstype;
	$nr = $result[0]->Løbenummer;
	//$return_string .=  "type = " . $type . ", nr = " . $nr . '<br>';
	if (($type == '5') || ($type == '7') || ($type == '8')) {
		if ($type == '5') {
			$return_string .= '<strong>' . $result[0]->Enhedsnavn . ' afdeling</strong><br>';
		} else {
			$return_string .= '<strong>' . $result[0]->Enhedsnavn . '</strong><br>';
		}
		$desc = $result[0]->Enhedsbeskrivelse;
		if (($desc != null) && (strlen($desc)> 0)) {
			$desc = str_replace("\n", "<br>", $desc);
			$return_string .= $desc . '<br>';
		}
		$tlf = $result[0]->Tlf;
		if (($tlf != null) && (strlen($tlf)> 0)) {
			$return_string .= 'Tlf: ' . $tlf . '<br>';
		}
		$email = $result[0]->Email;
		if (($email != null) && (strlen($email)> 0)) {
			$return_string .= 'E-mail: ' . $email . '<br>';
		}
		$facebook = $result[0]->Facebook;
		if (($facebook != null) && (strlen($facebook)> 0)) {
			$return_string .= 'Facebook:  <a href="' . $facebook . '">' . $facebook . '</a><br>';
		}
		$homepage = $result[0]->Hjemmeside;
		if (($homepage != null) && (strlen($homepage)> 0)) {
			$return_string .= 'Hjemmeside:  <a href="' . $homepage . '">' . $homepage . '</a><br>';
		}
		
		$max = sizeof($result);
      //		$return_string .= 'Max = ' . $max . '<br>';
      //		if ($max > 4) $max = 4;
		for ($i = 1; $i<$max; $i++) {
			$profil = $result[$i]->Profil;
      //			$return_string .= 'Profile = ' . $profil . '<br>';
			switch ($profil) {
				case 68:
					// Kontaktperson for afdeling
					$return_string .= '<br>';
					$return_string .= 'Kontaktperson<br>';
					$return_string .= "<strong>" . $result[$i]->Navn . '</strong><br>';
					$return_string .= contact_inf($result[$i]);
					break;
				case 87:
					// Kontaktperson for netværk
					$return_string .= '<br>';
					$return_string .= 'Kontaktperson<br>';
					$return_string .= "<strong>" . $result[$i]->Navn . '</strong><br>';
					$return_string .= contact_inf($result[$i]);
					break;
				case 96:
					// Kontaktperson for udvalg
					$return_string .= '<br>';
					$return_string .= 'Kontaktperson<br>';
					$return_string .= "<strong>" . $result[$i]->Navn . '</strong><br>';
					$return_string .= contact_inf($result[$i]);
					break;
				case 97:
					// KB-medlem
					$return_string .= '<br>';
					$return_string .= 'KB-medlem<br>';
					$beskr = $result[$i]->Beskrivelse;
					if (($beskr != null) && (strlen($beskr)> 0)) {
						$return_string .= $beskr . '<br>';
					}
					$return_string .= $result[$i]->Navn . '<br>';
					$tlf = $result[$i]->Tlf;
					if (($tlf != null) && (strlen($tlf)> 0)) {
						$return_string .= 'Tlf: ' . $tlf . '<br>';
					}
					$email = $result[$i]->Email;
					if (($email != null) && (strlen($email)> 0)) {
						$return_string .= 'E-mail: ' . $email . '<br>';
					}
					break;
			}
		}
	} else {
		$return_string .= $type . "<br>";
	}
	return $return_string;
}



function get_local_info($afd_navn){
   /*Denne funktion erstatter show_afdeling() på siden med lokalafdelinger. Den samler al infor om den enkelte lokalafdeling i et array "$allvalues", der kan bruges andre steder og har adskildt databasens  output fra html struktur*/ 

   global $wpdb;
   $db = new wpdb('c2telefonbog','tl6bwsS-Txr581lpIG4','c2telefonbog','v0062.dotserv.com'); /*forbind til databasen*/
   
   $enhedsnavn = spaces($afd_navn);
	$query = 'SELECT * FROM elprod WHERE Enhedsnavn = "' . $enhedsnavn . '"  ORDER BY Enhedstype DESC, Profil'; /*Hent data fr db*/
	$result = $db->get_results($query);
   $count1 = count($result);

   $allValues = array(); /*Tom array til at holde key => value par*/
	
	
	
	$type = $result[0]->Enhedstype;
	$nr = $result[0]->Løbenummer;
	//$return_string .=  "type = " . $type . ", nr = " . $nr . '<br>';
	if (($type == '5') || ($type == '7') || ($type == '8')) {
		if ($type == '5') {
			$allValues['afdName']= $result[0]->Enhedsnavn .' afdeling';
		} else {
			$allValues['afdName']=  $result[0]->Enhedsnavn ;
		}
		$desc = $result[0]->Enhedsbeskrivelse;
		if (($desc != null) && (strlen($desc)> 0)) {
			$allValues['desc']= $desc ;
		}
		$tlf = $result[0]->Tlf;
		if (($tlf != null) && (strlen($tlf)> 0)) {
			$allValues['phoneNum']=  $tlf ;
		}
		$email = $result[0]->Email;
		if (($email != null) && (strlen($email)> 0)) {
			$allValues['mail']=  $email ;
		}
		$facebook = $result[0]->Facebook;
		if (($facebook != null) && (strlen($facebook)> 0)) {
			$allValues['fb']= $facebook ;
		}
		$homepage = $result[0]->Hjemmeside;
		if (($homepage != null) && (strlen($homepage)> 0)) {
			$allValues['hp']= $homepage ;
		}
		
		$max = sizeof($result);
      //		$return_string .= 'Max = ' . $max . '<br>';
      //		if ($max > 4) $max = 4;
		for ($i = 1; $i<$max; $i++) {
			$profil = $result[$i]->Profil;
      //			$return_string .= 'Profile = ' . $profil . '<br>';
			switch ($profil) {
				case 68:
					// Kontaktperson for afdeling
					
					$allValues['contPers']=  $result[$i]->Navn ;
					$allValues['phoneNum'] = $return_string .= contact_inf_phone($result[$i]);
					break;
				
			}
		}
	} 
	return $allValues; /** Array med værdier returneres */ 
}








/**/
/**
 * Returns a list contact persons of the copenhagen sections
 *
 * @atts array of attribute values
 * @return a list contact persons of the copenhagen sections
 */
function mit_enhedslisten_function($atts) {
	global $wpdb;
   //	$mydb = $wpdb;
	$mydb = new wpdb('c2telefonbog','tl6bwsS-Txr581lpIG4','c2telefonbog','v0062.dotserv.com');

	
	$parms = shortcode_atts(array( 					'job' => 'empty',
									'udelukket' => 'empty',
									'vist' => 'empty',
									'afdelinger' => 'empty', 
									'afdeling' => 'empty',
									'udvalgene' => 'empty',
									'netvaerkene' => 'empty',
									'ansatte' => 'empty',
									'hb' => 'empty',), $atts);
	//$count = extract(shortcode_atts(array( 'sections' => 'empty', ), $atts));
	$results = "";
	$results .= $parms['afdelinger'] . " " . $parms['afdeling'];
	
	$job = $parms['job'];
	switch ($job) {
		case 'afdelinger':
			//$result .= 'Job = ' . $job . '<br>';
			$result .= list_afdelinger($mydb, $parms['udelukket']);
			break;
		case 'afdeling':
			//$result .= 'Job = ' . $job . '<br>';
			if (isset($_GET['afd'])) {
				$afd_navn = $_GET['afd'];
			} else {
				//Handle the case where there is no parameter
				$afd_navn = 'Aabenraa';		
			}

			//$result .= $afd_navn . "<br>";
			$result .= show_afdeling($mydb, $afd_navn);
			break;
		case 'kontakter':
			$result .= list_kontakter($mydb, $parms['vist']);
			break;
		case 'udvalgene':
			//$result .= 'Job = ' . $job . '<br>';
			$result .= list_udvalg($mydb, $parms['udelukket']);
			break;
		case 'netvaerkene':
			//$result .= 'Job = ' . $job . '<br>';
			// Liste over netværkene
			$result .= list_networks($mydb);
			break;
		case 'ansatte':
			//$result .= 'Job = ' . $job . '<br>';
			// Liste over ansatte
			$result .= list_ansatte($mydb, $parms['udelukket']);
			break;
		case 'byraad':
			//$result .= 'Job = ' . $job . '<br>';
			$result .= list_byraad($mydb, 97);
			break;
		case 'regionsraad':
			//$result .= 'Job = ' . $job . '<br>';
   //			$result .= list_byraad($mydb, 98);
			$result .= list_regionsraad($mydb);
			break;
		case 'hb-medlem':
			//$result .= 'Job = ' . $job . '<br>';
			$result .= list_hbmedlem($mydb);
			break;
		case 'lu':
			//$result .= 'Job = ' . $job . '<br>';
			$result .= list_lu($mydb);
			break;
		case 'hb-fu':
			//$result .= 'Job = ' . $job . '<br>';
			$result .= list_hbfu($mydb);
			break;
		case 'telefonbog':
			//$result .= 'Job = ' . $job . '<br>';
			$text = '';		
			if (isset($_GET['text'])) {
				$text = $_GET['text'];
			}

			$result .= list_results($mydb, $text);
			break;
		default:
			$result .= 'Unknow Job = ' . $job . '<br>';
	}
	
	return $result;
}

add_shortcode('mit_enhedslisten', 'mit_enhedslisten_function');
?>
