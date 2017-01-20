<?php
	function show_sub($item) {
		if (!$item->available())
		{
			return "";
		}
		$string = "";
		$title = ($item->title_translated == 1) ? trans($item->title) : $item->title;
		if ($item->children->count() == 0)
		{
			$string .= view("layouts.elements.sidebar_item_single", ["title" => $item->title, "icon" => $item->icon, "url" => $item->url, "id" => $item->id_string]);
		}
		else
		{
			$string .= view("layouts.elements.sidebar_item_multi_open", ["title" => $item->title, "icon" => $item->icon, "id" => $item->id_string]);
			foreach ($item->children as $child)
			{
				$string .= show_sub($child);
			}
			$string .= view("layouts.elements.sidebar_item_multi_close");
		}
		return $string;
	}
?>

@foreach (App\Models\LBSM_item::whereNull("parent_id")->get() as $item)
	{!! show_sub($item) !!}
@endforeach

@push("css")
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/fontawesome-picker/css/fontawesome-iconpicker.css') }}">
@endpush

@push("script")
<script src="{{ asset('/fontawesome-picker/js/fontawesome-iconpicker.js') }}"></script>
@endpush