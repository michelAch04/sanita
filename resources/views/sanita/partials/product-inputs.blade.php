<input type="hidden" name="old_price" value="{{ $price->old_price }}">
<input type="hidden" name="type" value="{{ $price->type }}">
<input type="hidden" name="product_id" value="{{ $product->id }}">
<input type="hidden" name="quantity" value="{{ $totalStock }}">
<input type="hidden" name="unit_price" value="{{ $price->unit_price}}">
<input type="hidden" name="shelf_price" value="{{ $price->shelf_price }}">
<input type="hidden" name="description" value="{{ $product->{'small_description_'.app()->getLocale()} ?? $product->small_description_en }}">
<input type="hidden" name="name" value="{{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}">
<input type="hidden" name="ea-ca" value="{{ $product->ea_ca ?? 12 }}">
<input type="hidden" name="ea-pl" value="{{ $product->ea_pl ?? 144 }}">
<input type="hidden" name="min_quantity" value="{{ $price->min_quantity_to_order}}">
<input type="hidden" name="max_quantity" value="{{ $price->max_quantity_to_order}}">
@foreach($prices as $p)
@if($p->UOM === 'CA')
<input type="hidden" name="unit_price_ca" value="{{ $p->unit_price }}">
<input type="hidden" name="shelf_price_ca" value="{{ $p->shelf_price }}">
<input type="hidden" name="old_price_ca" value="{{ $p->old_price }}">
<input type="hidden" name="min_quantity_ca" value="{{ $p->min_quantity_to_order }}">
<input type="hidden" name="max_quantity_ca" value="{{ $p->max_quantity_to_order }}">
@elseif($p->UOM === 'PL')
<input type="hidden" name="unit_price_pl" value="{{ $p->unit_price }}">
<input type="hidden" name="shelf_price_pl" value="{{ $p->shelf_price }}">
<input type="hidden" name="old_price_pl" value="{{ $p->old_price }}">
<input type="hidden" name="min_quantity_pl" value="{{ $p->min_quantity_to_order }}">
<input type="hidden" name="max_quantity_pl" value="{{ $p->max_quantity_to_order }}">
@endif
@endforeach