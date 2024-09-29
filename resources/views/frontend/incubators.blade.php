@extends('layouts.landing')

@section('content')

    @include('frontend.incubators.hero')
    @include('frontend.incubators.companies')

    <script>
        let accordionsItems = document.querySelectorAll('.accordion li')

        accordionsItems.forEach(item => {
            item.addEventListener('click', () => {
                accordionsItems.forEach(item => {
                    item.classList.remove('opened')
                })

                item.classList.add('opened')
            })
        })
    </script>
@endsection
