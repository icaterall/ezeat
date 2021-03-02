      let today = new Date();
      let currentMonth = today.getMonth();
      let currentYear = today.getFullYear();
      let selectYear = document.getElementById("year");
      let selectMonth = document.getElementById("month");

      let months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

      let monthAndYear = document.getElementById("monthAndYear");
      showCalendar(currentMonth, currentYear);


/*      function next() {
          currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
          currentMonth = (currentMonth + 1) % 12;
          showCalendar(currentMonth, currentYear);
      }

      function previous() {
          currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
          currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
          showCalendar(currentMonth, currentYear);
      }

      function jump() {
          currentYear = parseInt(selectYear.value);
          currentMonth = parseInt(selectMonth.value);
          showCalendar(currentMonth, currentYear);
      }*/

      function showCalendar(month, year) {

          let firstDay = (new Date(year, month)).getDay();
          let daysInMonth = 14 - new Date(year, month, 32).getDate();

          let tbl = document.getElementById("calendar-body"); // body of the calendar

          // clearing all previous cells
          tbl.innerHTML = "";

          // filing data about month and in the page via DOM.
          monthAndYear.innerHTML = months[month] + " " + year;
          selectYear.value = year;
          selectMonth.value = month;

          // creating all cells
          let date = 1;
          for (let i = 0; i < 6; i++) {
              // creates a table row
              let row = document.createElement("tr");

              //creating individual cells, filing them up with data.
              for (let j = 0; j < 7; j++) {
                  if (i === 0 && j < firstDay) {
                      let cell = document.createElement("td");
                      cell.className = 'daybtn';
                      let cellText = document.createTextNode("");
                      cell.appendChild(cellText);
                      row.appendChild(cell);
                  } else if (date > daysInMonth) {
                      break;
                  } else {
                      let cell = document.createElement("td");

                      cell.className = 'daybtn';


                      let cellText = document.createTextNode(date);
                      if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                          cell.classList.add("bg-info");
                      } // color today's date


                      cell.appendChild(cellText);
                      row.appendChild(cell);
                      date++;
                  }


              }

              tbl.appendChild(row); // appending each row into calendar body.


          }


    $('.daybtn').on('click', function () {
        $(".errortime_message").css('display', 'none');
        $(".errorlocation_message").css('display', 'none');
        var celltd = $(this).html();
        $('td.is-selected').removeClass('is-selected'); //Remove active class from all td
        $(this).addClass('is-selected');


        var month = currentMonth + 1;
        if (month < 10)
            mymonth = ('0' + month);
        else mymonth = month;
        if (celltd < 10)
            mycelltd = ('0' + celltd);
        else mycelltd = celltd;

    order_date = year + "-" + mymonth + "-" + mycelltd;
    dateorder = 1;


var weekday = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
var d = new Date(order_date);

var day = weekday[d.getDay()];
var month = d.getMonth() + 1;
var date = d.getDate();
printDate = `${day} ${month}/${date}`;

$('#delivery_date').text(printDate);
$('#datetab').removeClass("s-btn--selected");
$('#timetab').addClass("s-btn--selected");
   $("#dateContent").css('display', 'none');
   $("#timeContent").css('display', 'block');

    });

}
//---------------------------------------------------------------
//Open When Calender Modal


//Open When Calender Modal
 $('#later').on('click', function (e) {
    e.preventDefault();
  $(".schedule_order").css('display', 'block');
  $(".asap").css('display', 'none');
  $('#asap').removeClass("s-btn--selected");
  $('#later').addClass("s-btn--selected");
   });

//Open When Calender Modal
 $('#asap').on('click', function (e) {
 if($('#is_open').val()==1) 
 {
    e.preventDefault();
  $(".schedule_order").css('display', 'none');
  $(".asap").css('display', 'block');
  $('#later').removeClass("s-btn--selected");
   $('#asap').addClass("s-btn--selected");
  }

   });







//Swap Time, Date Tabs

 $('#datetab').on('click', function () {
$('#timetab').removeClass("s-btn--selected");
$('#datetab').addClass("s-btn--selected");
$("#dateContent").css('display', 'block');
$("#timeContent").css('display', 'none');
   });

$('#timetab').on('click', function () {
if(order_date!=null)   
{
   $('#datetab').removeClass("s-btn--selected");
   $('#timetab').addClass("s-btn--selected");
   $("#dateContent").css('display', 'none');
   $("#timeContent").css('display', 'block');
}
else
{
$('#timetab').removeClass("s-btn--selected");
$('#datetab').addClass("s-btn--selected");
$("#dateContent").css('display', 'block');
$("#timeContent").css('display', 'none');
}

   });

//on Time Selected


//-----------Swap between time tabs

        $('.nextbtn').on('click', function (event) {
        $(".errortime_message").css('display', 'none');
        $(".errorlocation_message").css('display', 'none');
            event.preventDefault();
            var id = $('.timecontent:visible').data('id');
            var nextId = $('.timecontent:visible').data('id') + 1;
            $('[data-id="' + id + '"]').hide();
            $('[data-id="' + nextId + '"]').show();

            if ($('.backbtn:hidden').length == 1) {
                $('.backbtn').show();
            }
            if (nextId == 5) {
                $('.nextbtn').hide();
            }
        });


        $('.backbtn').on('click', function (event) {
         $(".errortime_message").css('display', 'none');
        $(".errorlocation_message").css('display', 'none');
            event.preventDefault();
            var id = $('.timecontent:visible').data('id');
            var prevId = $('.timecontent:visible').data('id') - 1;
            $('[data-id="' + id + '"]').hide();
            $('[data-id="' + prevId + '"]').show();

            if (prevId == 1) {
                $('.backbtn').hide();
                $('.nextbtn').show();

            }
        });


        $('#mainplaceorder').on('click', function (event) {

            $('#menu-item').modal('show');


        });



//select Time
$('.time-component__cell').on('click', function () {
     $(".errortime_message").css('display', 'none');
    $(".errorlocation_message").css('display', 'none');
$('.time-component__cell').removeClass("is-selected");
            var time = $(this).text();
            var hours_ampm = Number(time.match(/^(\d+)/)[1]);
            var hours = Number(time.match(/^(\d+)/)[1]);
            var minutes = Number(time.match(/:(\d+)/)[1]);

            var AMPM = time.match(/(am|pm)/gi);
            
            var am_pm = hours >= 12 ? 'pm' : 'am';

            if (AMPM == "PM" && hours < 12) hours = hours + 12;
            if (AMPM == "AM" && hours == 12) hours = hours - 12;
            var sHours = hours.toString();
            var sMinutes = minutes.toString();
            if (hours < 10) sHours = "0" + sHours;
            if (minutes < 10) sMinutes = "0" + sMinutes;
            order_time = sHours + ":" + sMinutes;
            var strTime = hours_ampm + ':' + sMinutes + am_pm;


            $(this).addClass("is-selected");
            $('#delivery_time').text(strTime);
            
            $(".show_datetime_btn").css('display', 'block');
            /* Ajax for Order Time */
     
        });

//Test if date time accepted

$('#check_order_time').on('click', function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'get',
                url: '/check_order_datetime/',


                data: {
                    'order_time': order_time,
                    'order_date': order_date,
                },

                beforeSend: function () {
                },

                success: function (data) {                     
                    timeaccepted=data.timeaccepted;
                   if(data.timeaccepted==1)
                   {
                   $('#update_order_status').html(data.update_order_status);
                    $('#calenderbody').removeClass("openDialog");
 
                   }

                   else
                   {
                    $('.date-toggle').html('When');
                     $(".errortime_message").css('display', 'block');
                    $('.date-toggle').css("font-size", 16 + "px");
                     
                   }

                                    }
                       });
                 });
