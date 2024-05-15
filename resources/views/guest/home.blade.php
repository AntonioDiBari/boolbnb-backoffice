@extends('layouts.app')
@section('content')
    <div class="container container-home-page">

        <div class="input-group py-5 serchbar-homepage">
            <input type="text" class="form-control" placeholder="" aria-describedby="button-addon1">
            <button class="btn btn-outline-primary" type="button" id="button-addon1">Cerca</button>
        </div>



        <div id="slider" class="carousel slide py-5 rouded text-center " data-bs-ride="carousel" data-bs-interval="2500">

            <div class="carousel-inner ">

                {{-- @foreach ($imageUrls as $key => $imageUrl)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img src="{{ $imageUrl }}" class="img-fluid w-100">
                        </div>
                    @endforeach --}}


            </div>
        </div>

    </div>

    <script>
        fetch('/get-image-urls')
            .then(response => response.json())
            .then(imageUrls => {
                const sliderInner = document.querySelector('.carousel-inner');
                imageUrls.forEach((imageUrl, index) => {
                    const carouselItem = document.createElement('div');
                    carouselItem.classList.add('carousel-item');
                    if (index === 0) {
                        carouselItem.classList.add('active');
                    }
                    const image = document.createElement('img');
                    image.classList.add('img-fluid', 'figure-img', 'w-100', 'img-carousel');
                    image.src = imageUrl;
                    carouselItem.appendChild(image);
                    sliderInner.appendChild(carouselItem);
                });
            })
            .catch(error => {
                console.error('Error fetching image URLs:', error);
            });
    </script>
@endsection
