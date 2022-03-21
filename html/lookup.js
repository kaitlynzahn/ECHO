google.charts.load('current', {
        'packages':['geochart'], 
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
});

      google.charts.setOnLoadCallback(drawRegionsMap);

//REGIONS MAP WORKS ACROSS THE COUNTRY
      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['State', 'Popularity'],
          ['US-IL', 200],
          ['IS-LA', 300],
          ['US-MO', 400],
          ['US-CA', 500],
          ['US-NM', 600],
          ['US-AL', 700]
        ]);
          

        var options = {
            resolution: 'provinces',
            region: 'US'
        };

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }

    google.charts.setOnLoadCallback(drawMarkersMap);


//MARKERS MAP CAN WORK FOR SPECIFIC CITIES, BUT HAS NO MARKERS SHOWING UP
      function drawMarkersMap() {
//      var data = google.visualization.arrayToDataTable([
//        ['City'],
//        ['900 Richmond Ave, Columbia']
//      ]);
          
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Address');
          
          data.addRows([
              ['900 Richmond Ave, Columbia, MO 65201, United States'],
              ['1 Hospital Dr, Columbia, MO 65201, United States']
          ]);

      var options = {
        region: 'US-MO',
          dataMode: 'markers',
        displayMode: 'markers',
          resolution: 'provinces',
        colorAxis: {colors: ['green', 'blue']}
      };

      var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    };






 google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
          
        data.addColumn('string', 'Test');
        data.addColumn('number', 'Value');
          
        data.addRows([
          ['test', 3],
          ['test2', 1],
          ['test1', 1],
          ['test3', 1],
          ['test4', 2]
        ]);

        var options = {'title':'Test Chart',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
          
        var chart = new google.visualization.Histogram(document.getElementById('histogram'));
        chart.draw(data, options);
          
        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart'));
        chart.draw(data, options);
          
        var chart = new google.visualization.BarChart(document.getElementById('barchart'));
        chart.draw(data, options);
      }



