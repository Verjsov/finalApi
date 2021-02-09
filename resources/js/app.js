require('./bootstrap');

require('alpinejs');

window.favorite = async function (e,icao) {
    const conf = confirm('A you sure to change favorite this station?')
    if (conf){
        let response = await fetch(`/api/add/favorite/${icao}`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json;charset=utf-8'},
        });
        let result = await response.json();
        window.location.reload()
    } else {
        e.preventDefault();
    }
}
