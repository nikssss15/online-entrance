function confirmation(){
    let check = window.confirm('You are about to start the exam, Are you ready? Once you click yes the timer will start.');
    if(check === true){
        window.location.href = "exam-taking.php";
    }
}

function scorechecker(){
    window.location.href = "view-exams.php";
}