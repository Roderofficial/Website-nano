<?php
function validate_embed($json_data){

    
    #check if json is valid
    try{
        $jdd = json_decode($json_data, true, $depth = 512, JSON_THROW_ON_ERROR);
    }catch (Exception $s){
        return False;
    }

    #check if content exist
    if(isset($jdd['content']) && $jdd['content'] != Null){
        $embed['content'] = $jdd['content'];
    }

    #validate embed
    if (isset($jdd['embed']) && $jdd['embed'] != Null){

        #validate color
        if(isset($jdd['embed']['color']) && $jdd['embed']['color'] != Null){
            #try change dec to hex color
            try{
                $hex_color = dechex($jdd['embed']['color']);
                #check if len is valid and preg
                if (strlen($hex_color) == 6 && preg_match("/([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/", $hex_color)){
                    $embed['embed']['color'] = $jdd['embed']['color'];
                    
                }else{
                    #invalid color
                    echo 'invalid Color';
                    return False;
                }

            }catch (Exception $e){
                echo 'Failed to validate color';
                return False;
            }catch (Throwable $e){
                echo 'Failed to validate color';
                return False;
            }
        }


        #validate title
        if (isset($jdd['embed']['title']) && $jdd['embed']['title'] != Null) {
            $embed['embed']['title'] = $jdd['embed']['title'];
        }
        #validate url
        if (isset($jdd['embed']['url']) && $jdd['embed']['url'] != Null) {
            $embed['embed']['url'] = $jdd['embed']['url'];
        }

        #validate description
        if (isset($jdd['embed']['description']) && $jdd['embed']['description'] != Null) {
            $embed['embed']['description'] = $jdd['embed']['description'];
        }

        #validate THUMBNAIL
        if (isset($jdd['embed']['thumbnail']['url']) && $jdd['embed']['thumbnail']['url'] != Null) {
            $embed['embed']['thumbnail']['url'] = $jdd['embed']['thumbnail']['url'];
        }


        #validate image
        if (isset($jdd['embed']['image']['url']) && $jdd['embed']['image']['url'] != Null) {
            $embed['embed']['image']['url'] = $jdd['embed']['image']['url'];
        }

        #validate footer
        if (isset($jdd['embed']['footer']) && $jdd['embed']['footer'] != Null) {
            
            #validate icon_url
            if(isset($jdd['embed']['footer']['icon_url']) && $jdd['embed']['footer']['icon_url'] != Null){
                $embed['embed']['footer']['icon_url'] = $jdd['embed']['footer']['icon_url'];
            }

            #validate text
            if (isset($jdd['embed']['footer']['text']) && $jdd['embed']['footer']['text'] != Null) {
                $embed['embed']['footer']['text'] = $jdd['embed']['footer']['text'];
            }

           
        }

        #validate author
        if (isset($jdd['embed']['author']) && $jdd['embed']['author'] != Null){

            #validate name
            if (isset($jdd['embed']['author']['name']) && $jdd['embed']['author']['name'] != Null) {
                $embed['embed']['author']['name'] = $jdd['embed']['author']['name'];
            }

            #validate url
            if (isset($jdd['embed']['author']['url']) && $jdd['embed']['author']['url'] != Null) {
                $embed['embed']['author']['url'] = $jdd['embed']['author']['url'];
            }

            #validate icon_url
            if (isset($jdd['embed']['author']['icon_url']) && $jdd['embed']['author']['icon_url'] != Null) {
                $embed['embed']['author']['icon_url'] = $jdd['embed']['author']['icon_url'];
            }

        }

        #validate fields
        if (isset($jdd['embed']['fields']) && $jdd['embed']['fields'] != Null) {
            #validate evry fields
            for ($i = 0; $i <= (sizeof($jdd['embed']['fields']) -1); $i++) {
                #validate name
                if (isset($jdd['embed']['fields'][$i]['name']) && $jdd['embed']['fields'][$i]['name'] != Null) {
                    $tempfields['name'] = $jdd['embed']['fields'][$i]['name'];
                } else {
                    return False;
                }

                #validate value
                if (isset($jdd['embed']['fields'][$i]['value']) && $jdd['embed']['fields'][$i]['value'] != Null) {
                    $tempfields['value'] = $jdd['embed']['fields'][$i]['value'];
                } else {
                    echo 2;
                    return False;
                }

                #validate inline
                if (isset($jdd['embed']['fields'][$i]['inline']) && ($jdd['embed']['fields'][$i]['inline'] == True || $jdd['embed']['fields'][$i]['inline'] == False)) {
                    $tempfields['inline'] = $jdd['embed']['fields'][$i]['inline'];
                } else {
                    $tempfields['inline'] = False;
                }


                #push tempfields to fields
                $embed['embed']['feilds'][] = $tempfields;
            }
        }









        
    }

    

    #debug dump
    #echo '<p style="font-size:25px;">------------------------ INPUT JSON DUMP -----------------------</p>';
    #var_dump($json_data);
    #echo '<p style="font-size:25px; color: red;">------------------------ ARRAY VALIDATED DUMP -----------------------</p>';
    #var_dump($embed);
    #echo '<p style="font-size:25px; color: blue;">------------------------ JSON VALIDATED DUMP -----------------------</p>';
    #var_dump(json_encode($embed));

    return json_encode($embed);
    
}
$body = file_get_contents('php://input');
var_dump(validate_embed($body));
?>