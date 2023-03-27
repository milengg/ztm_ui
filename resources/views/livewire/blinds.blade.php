<div class="p-6">
    <div id="blinds-main">
        <div class="flex justify-between">
            <p class="font-roboto text-2xl">ЩОРИ</p>
            <img class="" src="{{ asset('img/icons/blinds.png') }}" alt="blinds"/>
        </div>
        <div id="" class="text-center my-16">
            <p id="blinds-value" class="font-roboto text-8xl">
                {{$blindsDBValue->value}}<span class="font-roboto text-6xl absolute pt-1 pl-2">%</span>
            </p>
        </div>
        <div class="range-slider">
            <input id="blinds" type="range" value="{{$blindsDBValue->value}}" min="0" max="100" step="5"/>
        </div>
    </div>
</div>
@push('js')
<script>
    const blindsContainer = document.getElementById('blinds-main');
    const blindsRange = document.getElementById('blinds');

    const blinds = [
      { value: 30, class: 'text-teal-custom' },
      { value: 60, class: 'text-yellow-custom' },
      { value: 80, class: 'text-red-main' },
    ];

    function updateBlinds() {
      const value = parseInt(blindsRange.value);
    
      const blind = blinds.reduce((prev, curr) => {
        return curr.value <= value ? curr : prev;
      }, blinds[0]);

      const newClass = blind.class;
      const oldClass = blindsContainer.getAttribute('class');

     

    if(oldClass) {
        blindsContainer.classList.remove(oldClass);
      }
      blindsContainer.classList.add(newClass);
    }

    blindsRange.addEventListener('input', updateBlinds);
 
    updateBlinds();
</script>
@endpush