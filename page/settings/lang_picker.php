<?php
if (count(get_included_files()) == 1) exit("Direct access not permitted.");
@session_start();
require_once('functions.php');
$lang = get_lang($_SESSION['selected_guild']);

function is_selected($option, $lang)
{
  if ($option == $lang) {
    echo 'selected="selected"';
  }
}

?>

<select class="selectpicker" data-width="fit" name="lang">
  <option data-content='<i class="flag flag-united-kingdom"></i> English' <?= is_selected('en', $lang) ?>>en</option>
  <option data-content='<i class="flag flag-poland"></i> Polski' <?= is_selected('pl', $lang) ?>>pl</option>
</select>