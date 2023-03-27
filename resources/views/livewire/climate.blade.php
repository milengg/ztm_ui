<div class="p-6">
    <div id="climate-main">
        <div class="flex justify-between">
            <p class="font-roboto text-2xl">
                КЛИМАТИЗАЦИЯ
            </p>
            <svg class="climate" width="103" height="59" viewBox="0 0 103 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M102.313 29.2431V5.60302C102.313 2.53288 99.7797 0 96.7095 0H5.60305C2.53291 0 0 2.53288 0 5.60302V29.2431C0 32.3133 2.53291 34.8461 5.60305 34.8461H96.7095C99.7797 34.8461 102.313 32.39 102.313 29.2431ZM96.7095 33.004H5.60305C3.5307 33.004 1.84201 31.3155 1.84201 29.2431V5.60302C1.84201 3.53068 3.5307 1.8421 5.60305 1.8421H96.7095C98.7819 1.8421 100.47 3.53068 100.47 5.60302V29.2431C100.47 31.3155 98.7819 33.004 96.7095 33.004Z" fill="#2ACCB5"/>
                <path d="M93.1196 22.1818H8.92101C8.38373 22.1818 8 22.5655 8 23.1028V24.4076C8 26.787 9.38145 28.6291 11.1468 28.6291H90.9705C92.7358 28.6291 94.1175 26.787 94.1175 24.4076V23.1028C94.0407 22.5655 93.6569 22.1818 93.1196 22.1818ZM92.1986 24.4076C92.1986 25.7892 91.5079 26.787 90.8939 26.787H11.0701C10.4561 26.787 9.76518 25.7892 9.76518 24.4076V24.0238H92.1218L92.1986 24.4076Z" fill="#2ACCB5"/>
                <path d="M23.842 57.6511V39.921C23.842 39.3838 23.4583 39 22.921 39C22.3837 39 22 39.3838 22 39.921V57.6511C22 58.1884 22.3837 58.5722 22.921 58.5722C23.3815 58.5722 23.842 58.1884 23.842 57.6511Z" fill="#2ACCB5"/>
                <path d="M9.84201 51.8178V39.921C9.84201 39.3838 9.45828 39 8.92101 39C8.38373 39 8 39.3838 8 39.921V51.8178C8 52.3551 8.38373 52.7389 8.92101 52.7389C9.45828 52.7389 9.84201 52.2784 9.84201 51.8178Z" fill="#2ACCB5"/>
                <path d="M79.8422 56.8836V39.921C79.8422 39.3838 79.4583 39 78.921 39C78.3837 39 78 39.3838 78 39.921V56.8836C78 57.4208 78.3837 57.8046 78.921 57.8046C79.4583 57.8046 79.8422 57.3441 79.8422 56.8836Z" fill="#2ACCB5"/>
                <path d="M51.842 56.8836V39.921C51.842 39.3838 51.4583 39 50.921 39C50.3837 39 50 39.3838 50 39.921V56.8836C50 57.4208 50.3837 57.8046 50.921 57.8046C51.4583 57.8046 51.842 57.3441 51.842 56.8836Z" fill="#2ACCB5"/>
                <path d="M93.8422 51.8178V39.921C93.8422 39.3838 93.4585 39 92.9212 39C92.3839 39 92 39.3838 92 39.921V51.8178C92 52.3551 92.3839 52.7389 92.9212 52.7389C93.4585 52.7389 93.8422 52.2784 93.8422 51.8178Z" fill="#2ACCB5"/>
                <path d="M65.8422 51.8178V39.921C65.8422 39.3838 65.4585 39 64.9212 39C64.3839 39 64 39.3838 64 39.921V51.8178C64 52.3551 64.3839 52.7389 64.9212 52.7389C65.4585 52.7389 65.8422 52.2784 65.8422 51.8178Z" fill="#2ACCB5"/>
                <path d="M37.8422 51.8178V39.921C37.8422 39.3838 37.4585 39 36.9212 39C36.3839 39 36 39.3838 36 39.921V51.8178C36 52.3551 36.3839 52.7389 36.9212 52.7389C37.4585 52.7389 37.8422 52.2784 37.8422 51.8178Z" fill="#2ACCB5"/>
            </svg>
        </div>
        <div class="text-center my-16">
            <img id="arrow-container" class="absolute pl-5 pt-2" src="" alt="arrow"/>
            <p id="climate-value" class="font-roboto text-8xl">
                {{$ClimateDBValue->value}}<span class="font-roboto text-6xl absolute pt-1 pl-2">°C</span> 
            </p>
        </div>
        <div class="range-slider">
            <input id="climate" type="range" step="0.5" value="{{$ClimateDBValue->value}}" min="21" max="28"/>
        </div>
    </div>
</div>
@push('js')
<script>
    const arrowContainer = document.getElementById('arrow-container');
    const mainContainer = document.getElementById('climate-main');
    const rangeInput = document.getElementById('climate');

    const images = [
      { value: 21, url: '{{ asset('/img/icons/blue/1.png')}}', class: 'text-teal-custom' },
      { value: 22, url: '{{ asset('/img/icons/blue/2.png')}}', class: 'text-teal-custom' },
      { value: 23, url: '{{ asset('/img/icons/blue/3.png')}}', class: 'text-teal-custom' },
      { value: 24, url: '{{ asset('/img/icons/blue/4.png')}}', class: 'text-teal-custom' },
      { value: 25, url: '{{ asset('/img/icons/red/1.png')}}', class: 'text-red-main' },
      { value: 26, url: '{{ asset('/img/icons/red/2.png')}}', class: 'text-red-main' },
      { value: 27, url: '{{ asset('/img/icons/red/3.png')}}', class: 'text-red-main' },
      { value: 28, url: '{{ asset('/img/icons/red/4.png')}}', class: 'text-red-main' },
    ];

    function updateImage() {
      const value = parseInt(rangeInput.value);
    
      const image = images.reduce((prev, curr) => {
        return curr.value <= value ? curr : prev;
      }, images[0]);
    
      arrowContainer.src = image.url;
      const newClass = image.class;
      const oldClass = mainContainer.getAttribute('class');

      if(oldClass) {
        mainContainer.classList.remove(oldClass);
      }
      mainContainer.classList.add(newClass);
    }

    rangeInput.addEventListener('input', updateImage);
 
    updateImage();
</script>
@endpush