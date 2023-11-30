const time = document.getElementById('time');
const date = document.getElementById('date');

const monthNames = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto',
 'septiembre', 'octubre', 'noviembre', 'diciembre'];

const interval = setInterval(() => {

    const local = new Date();
    
    let day = local.getDate(),
        month = local.getMonth(),
        year = local.getFullYear();

    time.innerHTML = local.toLocaleTimeString();
    date.innerHTML = `${day} ${monthNames[month]} ${year}`;

}, 1);