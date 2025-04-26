@extends('admin.dashboard')

@section('content')
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    } 
    .profile-card {
        display: flex;
        border: 1px solid lightpink;
        width: 100%;
        height: 400px;
        background-color: lightblue;
    }
    .profile-left {
        width: 30%;
        border: 1px solid lightpink;
        background-color: lightgreen;
        flex-direction: column;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .profile-image {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        overflow: hidden;
    }
    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-left input[type="file"] {
        margin-top: 10px;
        padding: 5px;
        border: 1px solid lightpink;
        border-radius: 5px;
        margin: 0 auto;
    }

    .profile-card .profile-right {
        width: 70%;
        border: 1px solid lightpink;
        background-color: lightyellow;
        padding: 20px;
    }
    .profile-card .profile-right h2 {
        text-align: center;
    }
    .profile-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .profile-info label {
        font-weight: bold;
    }
</style>

    <div class="profile-card">
        <div class="profile-left">
            <div class="profile-image">
                <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMSEhUSE
                hIVFRUWFhUVFRUVFRcVFhUXFxUWGBUVFxUYHSggGBolGxYVITEhJSkrLi4uGB8zODMtNygtLisBCg
                oKDg0OGxAQGi0dHSUtLS0tLS0tLS0tLS0vLS0tLS0tLS0tLS0tLS0tLSstLS0tLS0tLS0tLS0tLS0
                tLy03Lf/AABEIAQwAvAMBIgACEQEDEQH/xAAbAAACAwEBAQAAAAAAAAAAAAAAAQIDBAUGB//EAD8Q
                AAEDAQUGBQIDBQcFAQAAAAEAAhEDBBIhMUEFUWFxgZEiobHB8BPRBjLhQlKiwvEUI3KCkrLiM2Jj0v
                MV/8QAGQEAAwEBAQAAAAAAAAAAAAAAAAECAwQF/8QAJREBAQACAgICAQQDAAAAAAAAAAECEQMhEjEi
                QVEEE0JhIzJx/9oADAMBAAIRAxEAPwDxiEk1KwhCEjNCSEA0JIQDQhCAaEkIBoQhIxKaSEBJCSEGaE
                ISBoQgJGEipEJFOCqUIQrZhCE0AISQgBNJNACEISM0JJhACaSEGaEISAQhNAEqSSElGmkFIJGFFymo
                uRBVCEIWjIIQhACEIQAhCEA0JJpGEIQgGhJBKAaJUC5K8novJamqbyYejR+UWphRBUpUKSQlKcpKMF
                DkryRciQWqE0QiFoyCEJIBoQhACEICAEIQgBNJCACVCUFCcibQhCEyCEIhANphW3lUpBTVypSi8opp
                HsSiUk0yJNJCAaEIhIEhOE2sJIA1wQaMIhSLTuShBEkrKdMuMAScT2Elan7LqCkKxGBOAgzdjF8aNy
                9ckbh6tYZSTjXTL52KRTSBkkhTYyU/Re0YQrSz53VaW1aEIAVjG4pUm5/PmaWz8UFJmfD2+eibmwmR
                BQWkSkpBqcBGz0ihSwVbjinCvRppIQAmkmgBabJTcHsN0wT4cDDuR1T2bYjWqNpgxenE6AAknyXvrr
                ZaI/KRA/dgYABY8nJ49NuPj8u3zog3QccDdPA6e/8ApK02Gg5xDiDcJc0u0BuE9NF6v/8AGp1X1XOk
                A3RAwxBJDucYJ2iwspNuMbDTJIkkEnmScgovNNaVOG77ef2dTusL3fmdeaOADXT6HyXqqfjpveYN6Q
                BoAAQABxleMtloc14Zoy8BxDp9oHReoslqAsxxxBx6lZ543/a/bTjs9fh5XarQHANAAjICBMnGN+Pk
                FXa7Jcp03HOoHHkBF3uDKjb6l5/IAe/utlrBqUaZibrbusANJHnA8l0S2TFj4zK5acpjVqaLreOPpg
                VC9czx4arOXFaa8mW/Frqtwn5kqGtWmi683sPP7FSo0hJB4weijemnjvtUxsHmpMZBG4gA9cD7KbWS
                MdPhCHiQN84df1hLZ6VVhl59DHsoRhO5XWh/374+sqlpwjgfb7Kp6RfatyE3aFJUkwk5MIJQEUIQmT
                Xsywms+4CG4EknHAQMBrmF0av4dcB4agcdxF2eEyQj8Jsd9UvEXWth87nHADjLZ/ynevTlrb90ZHWc
                5XNycmUy1HTxceNx3XjdkVTRtDC8FuMGRGDgWzjpjPReu2k+DM5eR+EHqsFusrXtLHD8pMOGY4j3C5
                Fl2qWX2VZcZAnP8ou4zngG48FOU/c7ntWP+Pq+nsbPVFwu1Prl7LHtWpMEaiV547ecy6GtluJMn8zT
                u3EEeS3P2xSqMbDoIBEOEEbueCj9vKd6X+5jetuDtgeMHePQqVa1FouAG8Yw55eyp2jaA90tyGAMZ7
                1VTfiXnE4nmSuqY/Gbcty+V0laokARgADGpjEnic13Pw/Umk4Z3TJbvBEyOOB7LzxM4rqbDtLWh7SY
                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" alt="">
            </div>
            <input type="file">
        </div>
        <div class="profile-right">
            <h2>Profile Information</h2>
            
            <div class="profile-info">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="Prince Erickson Sanado" disabled>
                </div>
                <div>
                    <label for="name1">Email:</label>
                    <input type="text" id="name1" name="name" value="Prince Erickson Sanado" disabled>
                </div>
                <div>
                    <label for="name2">Contact:</label>
                    <input type="text" id="name2" name="name" value="Prince Erickson Sanado" disabled>
                </div>
                <div>
                    <label for="name3">Birthday:</label>
                    <input type="text" id="name3" name="name" value="Prince Erickson Sanado" disabled>
                </div>
                <div>
                    <label for="name4">Name:</label>
                    <input type="text" id="name4" name="name" value="Prince Erickson Sanado" disabled>
                </div>
                <div>
                    <label for="name5">Name:</label>
                    <input type="text" id="name5" name="name" value="Prince Erickson Sanado" disabled>
                </div>
            </div>
        </div>
    </div>
@endsection