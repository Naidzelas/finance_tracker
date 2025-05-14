<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/js/app.js')
    @routes
    @vite('resources/css/app.css')
    @inertiaHead
  </head>
  <!-- #F4F0EF -->
  <body class="bg-[#F4F0EF]">
    @inertia
  </body>
</html>