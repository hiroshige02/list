@extends('layouts.app')
@section('contents')

<v-container>
    <items-pagenate
    datas='@json($datas)'
    :total-pages="{{ $total_pages }}"
    per-page="{{ $per_page }}"
    :return-page="{{ $return_page }}"
    maintenance="{{ $maintenance }}"
    ></items-pagenate>
</v-container>

@endsection
