<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Barang Masuk</title>
  <script>
    function subst() {
        var vars = {};
        var query_strings_from_url = document.location.search.substring(1).split('&');
        for (var query_string in query_strings_from_url) {
            if (query_strings_from_url.hasOwnProperty(query_string)) {
                var temp_var = query_strings_from_url[query_string].split('=', 2);
                vars[temp_var[0]] = decodeURI(temp_var[1]);
            }
        }
        var css_selector_classes = ['page', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate', 'time', 'title', 'doctitle', 'sitepage', 'sitepages'];
        for (var css_class in css_selector_classes) {
            if (css_selector_classes.hasOwnProperty(css_class)) {
                var element = document.getElementsByClassName(css_selector_classes[css_class]);
                for (var j = 0; j < element.length; ++j) {
                    element[j].textContent = vars[css_selector_classes[css_class]];
                }
            }
        }
    }
  </script>

<style>
        /* elements */
    body {
      font: 400 16px 'Muli', sans-serif !important;
      margin: 0;
      padding: 0;
    }

    header {
      margin: 0;
      max-width: 100%;
      padding: 5px;
      text-align: center;
      overflow: auto;
    }

    ul{
      list-style-type: none;
      margin: 0 auto;
      padding: 0
    }

    li{
      background: slategrey;
      display: inline-block;
      margin: 5px;
      padding: 5px 7px;
    }

    li > a {
      color: white; 
      font-size: 16px;
    }

    li > a:hover{
      color: #262626;
      text-decoration: none;
    }
    /* .periode {
      margin-left: 10px;
      max-width: 100%;
      padding: 5px;
      text-align: left;
      overflow: auto;
    } */

    .col-md-6{
      display: inline-block;
      margin-left: 4%;
      max-width: 48%;
      padding: 5px;
      text-align: left;
      overflow: auto;
    }

    /* .inner {
      padding: 30px;
    } */
    /* headings */

    .container-fluid h2 {
      font-family: 'Montserrat', sans-serif;
    }

    .reds{
      font-color:red;
      background-color: salmon;
    }

    .site-title {
      font-size: 50px;
      font-weight: 100;
      text-transform: uppercase;
    }

    /* text colors */

    .black,
    .k {
      font-color: #262626;
      background: #000;
    }

    /* background colors */

    .sq {
      /*  alignment  */
      float: left;
      margin: 5px;
      /*  size  */
      width: 200px;
      height: 200px;
      /*  box text  */
      color: #262626;
      text-align: center;
    }

    .sq:hover {
      border: 6px solid rgba(255,255,255, 0.5);
    }

    .sq p {
      vertical-align: middle;
      text-align: center;
      position: relative;
      top: 40px;
    }

    .c {
      display: block;
      width: 100px;
      height: 100px;
      border-radius: 100%;
      margin: 10px;
    }

    /* table */
    table{
      margin: 10px auto;
    }

    .jumlah {
      text-align: center;
    }

    .no {
      text-align: center;
    }

    table > tbody > tr.tableizer-firstrow > th {
      padding: 10px;
      background: lavenderblush;
    }

    body > div.container-fluid.inner > table > tbody > tr > td{
      border: 1px solid #fff;
      width: 170px;
      padding: 10px;
      background: #e4f7fd;
    }
</style>
</head>
<body style="border:0; margin: 0;" onload="subst()">

  

  @yield('content-pdf')
</body>
</html>