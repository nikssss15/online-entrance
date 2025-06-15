let startingMinutes = document.getElementById("minutes");
let startingSeconds = document.getElementById("seconds");

let minutesConvert = sessionStorage.getItem("startingMinutes");
let secondsConvert = sessionStorage.getItem("startingSeconds");

if(minutesConvert === null || secondsConvert === null){
    minutesConvert = parseInt(startingMinutes.innerHTML);
    secondsConvert = parseInt(startingSeconds.innerHTML);
}
else{
    minutesConvert = parseInt(minutesConvert);
    secondsConvert = parseInt(secondsConvert);
}

sessionStorage.setItem("startingMinutes", minutesConvert);
sessionStorage.setItem("startingSeconds", secondsConvert);

let timerMinutes = minutesConvert;
let timerSeconds = secondsConvert;

let timer = setInterval(function (){
    timerSeconds--;
    sessionStorage.setItem("startingSeconds", timerSeconds);
    if(timerSeconds < 0){
        if(timerSeconds <= 0 && timerMinutes <= 0){
            alert("times up");
            clearInterval(timer);
            document.getElementById("submit-exam").submit();
        }
        else{
            timerSeconds += 60;
            timerMinutes--;
            sessionStorage.setItem("startingMinutes", timerMinutes);
            sessionStorage.setItem("startingSeconds", timerSeconds);
            if (timerMinutes < 10){
                startingSeconds.innerHTML = timerSeconds;
                startingMinutes.innerHTML = "0" + timerMinutes;
                if (timerSeconds< 10){
                    startingSeconds.innerHTML = "0" + timerSeconds;
                    startingMinutes.innerHTML = timerMinutes;
                }
                else{
                    startingSeconds.innerHTML = timerSeconds;
                    startingMinutes.innerHTML = timerMinutes;
                }
            }
            else{
                startingSeconds.innerHTML = timerSeconds;
                startingMinutes.innerHTML = timerMinutes;
            }
            
        }   
    }
    else{
        if (timerSeconds< 10){
            startingSeconds.innerHTML = "0" + timerSeconds;
            startingMinutes.innerHTML = timerMinutes;
        }
        else{
            startingSeconds.innerHTML = timerSeconds;
            startingMinutes.innerHTML = timerMinutes;
        }   
    }
},1000);