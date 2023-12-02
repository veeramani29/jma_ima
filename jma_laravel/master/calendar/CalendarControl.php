<?php
$styleCalendarHeader	=	"d09300";
$styleCalendarWeekday	=	"faeed1";
$styleCalendarWeekend	=	"6283ff";
$styleCalendarBorder	=	"c37700";

?>
#CalendarControlIFrame {
  display: none;
  left: 0px;
  position: absolute;
  top: 0px;
  height: 250px;
  width: 250px;
  z-index: 5999;
}

#CalendarControl {
  position:absolute;
  background-color:#ffe09e;
  margin:0;
  padding:0;
  display:none;
  z-index: 6000;
}

#CalendarControl table {
  font-family: arial, verdana, helvetica, sans-serif;
  font-size: 8pt;
  border-left: 1px solid #336;
  border-right: 1px solid #336;
  border-top: 1px solid #336;
  border-bottom: 1px solid #336;
  width: 160px;
  background-color:#4d97e3;
}

#CalendarControl th {
  font-weight: normal;
  background-color:#ff9600;
}

#CalendarControl th a {
  font-weight: normal;
  text-decoration: none;
  color: #FFF;
  padding: 1px;
}

#CalendarControl td {
  text-align: center;
}

#CalendarControl .header {
  background-color: #<?php echo $styleCalendarHeader;?>;
}

#CalendarControl .weekday {
  background-color: #<?php echo $styleCalendarWeekday;?>;
  color: #000;
}

#CalendarControl .weekend {
  background-color: #<?php echo $styleCalendarWeekend;?>;
  color: #000;
}

#CalendarControl .current {
  border: 1px solid #<?php echo $styleCalendarBorder;?>;
  background-color: #<?php echo $styleCalendarBorder;?>;
  color: #FFF;
}

#CalendarControl .current1 {
  border: 1px solid #FFF;
  background-color: #<?php echo $styleCalendarBorder;?>;
  color: #FFF;
  width: 2em;  
}
#CalendarControl .weekday1 {
  border: 1px solid #FFF;
  background-color: #c1d9d1;
  color: #000;
  width: 2em;  
}

#CalendarControl .weekday,
#CalendarControl .weekend,
#CalendarControl .current {
  display: block;
  text-decoration: none;
  border: 1px solid #FFF;
  width: 2em;
}

#CalendarControl .weekday:hover,
#CalendarControl .weekend:hover,
#CalendarControl .current:hover {
  color: #FFFFFF;
  background-color: #73afb6;
  border: 1px solid #999;
}

#CalendarControl .previous {
  text-align: left;
}

#CalendarControl .next {
  text-align: right;
}

#CalendarControl .previous,
#CalendarControl .next {
  padding: 1px 3px 1px 3px;
  font-size: 1.4em;
}

#CalendarControl .previous a,
#CalendarControl .next a {
  color: #FFF;
  text-decoration: none;
  font-weight: bold;
}

#CalendarControl .title {
  text-align: center;
  font-weight: bold;
  color: #FFF;
}

#CalendarControl .empty {
  background-color: #BEC8B5;
  border: 1px solid #FFF;
}
