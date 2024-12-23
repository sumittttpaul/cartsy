<?php
$headerColorSchemaLoad = '';
$header_color_schema = [];

$screenID = CartsyGetCurrentPageID();

$headerDisplay        = CartsyLocalOptionData($screenID, '_header_switch', 'true');
$headerInitialColor   = CartsyLocalOptionData($screenID, '_header_initial_color', 'true');
$headerMenuColor      = CartsyLocalOptionData($screenID, '_header_menu_color', 'true');
$headerMenuHoverColor = CartsyLocalOptionData($screenID, '_header_menu_hover_color', 'true');

array_push($header_color_schema, [
    'defaultHeaderColor'   => $headerInitialColor,
    'headerMenuColor'      => $headerMenuColor,
    'headerMenuHoverColor' => $headerMenuHoverColor,
]);
$headerColorSchemaValue = HeaderDynamicCSS($header_color_schema);

if (!empty($headerColorSchemaValue)) {
    $headerColorSchemaLoad .= "style='$headerColorSchemaValue'";
}

$headerColorSchemaLoad = apply_filters('cartsy_header_color_scheme', $headerColorSchemaLoad);

?>

<div class="cartsy-menu-area" <?php echo esc_attr($headerColorSchemaLoad); ?>>