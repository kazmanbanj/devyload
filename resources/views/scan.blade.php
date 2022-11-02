@extends('layouts.app')

@section('content')
<template>
    <ais-instant-search :search-client="searchClient" index-name="demo_ecommerce">
    <ais-search-box />
    <ais-hits>
        <template v-slot:item="{ item }">
        <h2>{{ item.title }}</h2>
        </template>
    </ais-hits>
    </ais-instant-search>
<template>

    {{-- <ais-instant-search>
    <ais-index app-id="latency" api-key="536cdb23840da5ba2a2ed858480ee5ab" index-name="bestbuy">
        <ais-search-box></ais-search-box>
        <ais-results></ais-results>
        <ais-results>
            <template scope="{ result }">
                <h2>
                    <ais-highlight :result="result" attribute-name="name"></ais-highlight>
                </h2>
            </template>
        </ais-results>
    </ais-index>
</ais-instant-search> --}}

<style>
body {
    font-family: sans-serif;
    padding: 1em;
}
</style>

@endsection

@section('script')
<script>
    import algoliasearch from 'algoliasearch/lite';
    import 'instantsearch.css/themes/satellite-min.css';

    export default {
        data() {
            return {
                searchClient: algoliasearch(
                    'B1G2GM9NG0',
                    'aadef574be1f9252bb48d4ea09b5cfe5'
                ),
            };
        },
    };
</script>
@endsection