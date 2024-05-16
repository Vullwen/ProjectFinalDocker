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
        fetchProperties: function() {
            const activeParams = Object.entries(this.searchParams)
                                       .reduce((acc, [key, value]) => {
                                           if (value) acc[key] = value;
                                           return acc;
                                       }, {});

            axios.get('../../PCS_ADMIN/pages/biens/searchProperties.php', {
                params: activeParams
            })
            .then(response => {
                this.properties = response.data;
            })
            .catch(error => {
                console.error("Error fetching properties: ", error);
                alert('Failed to fetch properties. Please check the console for more information.');
            });
        }
    }
});
