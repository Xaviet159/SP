// calcul seconde/jour
const DAYS = 24 * (60 * 60)

function refreshCountdown() {
    // Calcule de la différence "en jour" entre les 2 dates
    const countdown = document.querySelector('#countdown')
    const launchDate = Date.parse(countdown.dataset.time) / 1000
    const difference = launchDate - Date.now() / 1000
    const diff = Math.floor(difference / DAYS)

    // Injection dans l'html
    if(diff >= 0){
        document.getElementById('days').innerText = diff
    }else{
        document.getElementById('days').innerText = "Aucun"
    }

    window.setTimeout(refreshCountdown, DAYS)
}

refreshCountdown()

