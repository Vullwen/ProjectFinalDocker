new Vue({
    el: '#app',
    data: {
        searchParams: {
            location: '',
            arrivalDate: '',
            departureDate: '',
            adults: '',
            children: '',
            bedrooms: ''
        },
        properties: []
    },
    methods: {
        fetchProperties: function () {
            const activeParams = Object.entries(this.searchParams)
                .reduce((acc, [key, value]) => {
                    if (value) acc[key] = value;
                    return acc;
                }, {});

            axios.get('http://51.75.69.184/2A-ProjetAnnuel/PCS/PCS_ADMIN/pages/biens/searchProperties.php', {
                params: activeParams
            })
                .then(response => {
                    const baseUrl = 'http://51.75.69.184/2A-ProjetAnnuel/PCS/Site/';

                    this.properties = response.data.map(property => {
                        axios.get('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/demandesBiens/photos', {
                            params: { idBien: property.IDBien }
                        })
                            .then(photoResponse => {
                                if (photoResponse.data.photos && photoResponse.data.photos.length > 0) {
                                    property.photos = photoResponse.data.photos.map(photo => baseUrl + photo.cheminPhoto);
                                } else {
                                    property.photos = '../../PCS_ADMIN/img/home_icon.png';
                                }
                            })
                            .catch(error => {
                                console.error("Error fetching photo: ", error);
                                property.photos = '../../PCS_ADMIN/img/home_icon.png';
                            });

                        return property;
                    });
                })
                .catch(error => {
                    console.error("Error fetching properties: ", error);
                    alert('Failed to fetch properties. Please check the console for more information.');
                });
        }
    }
});
