<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gumilang | Movies</title>
    {{-- style --}}
    @vite('resources/css/app.css')
</head>

<body>
    <div class="w-full h-auto min-h-screen flex flex-col">
        {{-- Header Section --}}
        @include('header')

        {{-- Banner Section --}}
        <div class="w-full h-[512px] flex flex-col relative bg-sky-500">

            {{-- Banner Data --}}
            @foreach ($banner as $bannerItem)
                @php
                    $bannerImage = "{$imageBaseURL}/original{$bannerItem->backdrop_path}";
                @endphp

                <div class="flex flex-row items-center w-full h-full relative slide">
                    {{-- Img --}}
                    <img src="{{ $bannerImage }}" class="absolute w-full h-full object-cover">

                    {{-- Overlay --}}
                    <div class="w-full h-full absolute bg-black bg-opacity-40"></div>

                    <div class="w-10/12 flex flex-col ml-28 z-10">
                        <span class="font-bold font-inter text-4xl text-white">{{ $bannerItem->title }}</span>
                        <span
                            class="font-inter text-xl text-white w-1/2 line-clamp-2">{{ $bannerItem->overview }}</span>

                        <a href="/movie/{{ $bannerItem->id }}"
                            class="w-fit bg-sky-500 text-white pl-2 pr-4 py-2 mt-5 font-inter text-sm flex flex-row rounded-lg items-center hover:drop-shadow-lg duration-200">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.525 18.025C9.19167 18.2417 8.854 18.254 8.512 18.062C8.17067 17.8707 8 17.575 8 17.175V6.82499C8 6.42499 8.17067 6.12899 8.512 5.93699C8.854 5.74566 9.19167 5.75832 9.525 5.97499L17.675 11.15C17.975 11.35 18.125 11.6333 18.125 12C18.125 12.3667 17.975 12.65 17.675 12.85L9.525 18.025Z"
                                    fill="white" />
                            </svg>
                            <span class="">Detail</span>
                        </a>
                    </div>
                </div>
            @endforeach

            {{-- Prev Button --}}
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(-1)">
                <button class="bg-white p-3 rounded-lg opacity-50 hover:opacity-100 duration-200">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.85 2.9C17.1 3.15 17.225 3.446 17.225 3.788C17.225 4.12933 17.1 4.425 16.85 4.675L9.525 12L16.875 19.35C17.1083 19.5833 17.225 19.875 17.225 20.225C17.225 20.575 17.1 20.875 16.85 21.125C16.6 21.375 16.304 21.5 15.962 21.5C15.6207 21.5 15.325 21.375 15.075 21.125L6.675 12.7C6.575 12.6 6.504 12.4917 6.462 12.375C6.42066 12.2583 6.4 12.1333 6.4 12C6.4 11.8667 6.42066 11.7417 6.462 11.625C6.504 11.5083 6.575 11.4 6.675 11.3L15.1 2.875C15.3333 2.64167 15.6207 2.525 15.962 2.525C16.304 2.525 16.6 2.65 16.85 2.9Z"
                            fill="black" />
                    </svg>
                </button>
            </div>

            {{-- Next Button --}}
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(1)">
                <button class="bg-white p-3 rounded-lg opacity-50 hover:opacity-100 duration-200 rotate-180">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.85 2.9C17.1 3.15 17.225 3.446 17.225 3.788C17.225 4.12933 17.1 4.425 16.85 4.675L9.525 12L16.875 19.35C17.1083 19.5833 17.225 19.875 17.225 20.225C17.225 20.575 17.1 20.875 16.85 21.125C16.6 21.375 16.304 21.5 15.962 21.5C15.6207 21.5 15.325 21.375 15.075 21.125L6.675 12.7C6.575 12.6 6.504 12.4917 6.462 12.375C6.42066 12.2583 6.4 12.1333 6.4 12C6.4 11.8667 6.42066 11.7417 6.462 11.625C6.504 11.5083 6.575 11.4 6.675 11.3L15.1 2.875C15.3333 2.64167 15.6207 2.525 15.962 2.525C16.304 2.525 16.6 2.65 16.85 2.9Z"
                            fill="black" />
                    </svg>
                </button>
            </div>

            {{-- Indikator --}}
            <div class="absolute bottom-0 w-full mb-8">
                <div class="w-full flex flex-row items-center justify-center">
                    @for ($pos = 1; $pos <= count($banner); $pos++)
                        <div class="w-2.5 h-2.5 rounded-full mx-1 cursor-pointer dot"
                            onclick="currentSlide({{ $pos }})"></div>
                    @endfor
                </div>
            </div>

        </div>
    </div>
    <script>
        // Deafult active slide
        let slideIndex = 1;
        showSlide(slideIndex);

        function showSlide(position) {
            let index;
            const slidesArray = document.getElementsByClassName("slide");
            const dotsArray = document.getElementsByClassName("dot");

            // Looping effect
            if (position > slidesArray.length) {
                slideIndex = 1;
            }

            if (position < 1) {
                slideIndex = slidesArray.length;
            }

            // Hide all slides
            for (index = 0; index < slidesArray.length; index++) {
                slidesArray[index].classList.add('hidden');
            }

            // Show active slides
            slidesArray[slideIndex - 1].classList.remove('hidden');

            // Remove active status
            for (index = 0; index < dotsArray.length; index++) {
                dotsArray[index].classList.remove('bg-sky-500');
                dotsArray[index].classList.add('bg-white');
            }

            // Set active status
            dotsArray[slideIndex - 1].classList.remove('bg-white');
            dotsArray[slideIndex - 1].classList.add('bg-sky-500');
        }

        function moveSlide(moveStep) {
            showSlide(slideIndex += moveStep)
        }

        function currentSlide(position) {
            showSlide(slideIndex = moveStep)
        }
    </script>
</body>

</html>
