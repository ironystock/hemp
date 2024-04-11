<!DOCTYPE html>
<html>
    <head>
    <script src="https://unpkg.com/htmx.org@1.9.11" integrity="sha384-0gxUXCCR8yv9FM2b+U3FDbsKthCI66oH5IA9fHppQq9DDMHuMauqq1ZHBpJxQ0J0" crossorigin="anonymous"></script>
    </head>
    <body>

    <button 
        hx-get="./headers/"
        hx-target="#headers"
        >
        Load Headers
    </button>
    <div id="headers"></div>

    </body>
</html>