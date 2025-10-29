// Swiper para equipo
const swiper = new Swiper('.mySwiper', {
    loop: true,
    spaceBetween: 24,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: { slidesPerView: 1 },
        768: { slidesPerView: 3 }
    }
});

// Swiper para servicios jurídicos
const serviciosSwiper = new Swiper('.serviciosSwiper', {
    loop: true,
    spaceBetween: 24,
    slidesPerView: 1,
    slidesPerGroup: 1,
    grid: {
        rows: 1,
        fill: 'row'
    },
    pagination: {
        el: '.serviciosSwiper .swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.serviciosSwiper .swiper-button-next',
        prevEl: '.serviciosSwiper .swiper-button-prev',
    },
    breakpoints: {
        0: { 
            slidesPerView: 1,
            slidesPerGroup: 1,
            grid: {
                rows: 1,
                fill: 'row'
            }
        },
        768: { 
            slidesPerView: 2,
            slidesPerGroup: 2,
            grid: {
                rows: 1,
                fill: 'row'
            }
        },
        1024: { 
            slidesPerView: 3,
            slidesPerGroup: 6,
            grid: {
                rows: 2,
                fill: 'row'
            }
        }
    }
});

// Función para expandir/contraer descripción de servicios
function toggleDescripcion(element) {
    const card = element.closest('.servicio-card');
    const descripcion = card.querySelector('.servicio-descripcion');
    
    if (descripcion.classList.contains('collapsed')) {
        descripcion.classList.remove('collapsed');
        descripcion.classList.add('expanded');
        card.classList.add('expanded');
        element.textContent = 'Leer menos';
    } else {
        descripcion.classList.remove('expanded');
        descripcion.classList.add('collapsed');
        card.classList.remove('expanded');
        element.textContent = 'Leer más';
    }
}

// Inicialización del mapa de Google Maps (callback)
window.initMap = function() {
    // MAP_LOCATIONS se inyecta desde PHP en landing.blade.php
    const hasLocations = typeof MAP_LOCATIONS !== 'undefined' && Array.isArray(MAP_LOCATIONS) && MAP_LOCATIONS.length > 0;
    const defaultCenter = hasLocations 
        ? { lat: MAP_LOCATIONS[0].lat, lng: MAP_LOCATIONS[0].lng }
        : { lat: 13.69294, lng: -89.21819 }; // San Salvador como fallback

    const map = new google.maps.Map(document.getElementById('map'), {
        center: defaultCenter,
        zoom: hasLocations ? 12 : 5,
        mapTypeControl: false,
        streetViewControl: false,
        fullscreenControl: true,
    });

    const bounds = new google.maps.LatLngBounds();
    const infoWindow = new google.maps.InfoWindow();

    if (hasLocations) {
        MAP_LOCATIONS.forEach(loc => {
            const position = { lat: Number(loc.lat), lng: Number(loc.lng) };
            const marker = new google.maps.Marker({
                position,
                map,
                title: loc.title || '',
            });
            bounds.extend(position);
            marker.addListener('click', () => {
                infoWindow.setContent(`<div style="min-width:180px"><strong>${loc.title || ''}</strong><br><span style="color:#6c757d">${loc.description || ''}</span></div>`);
                infoWindow.open(map, marker);
            });
        });

        if (MAP_LOCATIONS.length > 1) {
            map.fitBounds(bounds);
        }
    }
}
