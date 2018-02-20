﻿/*!
 * Datetimepicker for Bootstrap 3
 * version : 4.17.37
 * https://github.com/Eonasdan/bootstrap-datetimepicker/
 */
.bootstrap-datetimepicker-widget {
  list-style: none;
}
.bootstrap-datetimepicker-widget.dropdown-menu {
  margin: 2px 0;
  padding: 4px;
  width: 19em;
}
@media (min-width: 768px) {
  .bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
    width: 38em;
  }
}
@media (min-width: 992px) {
  .bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
    width: 38em;
  }
}
@media (min-width: 1200px) {
  .bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
    width: 38em;
  }
}
.bootstrap-datetimepicker-widget.dropdown-menu:before,
.bootstrap-datetimepicker-widget.dropdown-menu:after {
  content: '';
  display: inline-block;
  position: absolute;
}
.bootstrap-datetimepicker-widget.dropdown-menu.bottom:before {
  border-left: 7px solid transparent;
  border-right: 7px solid transparent;
  border-bottom: 7px solid #cccccc;
  border-bottom-color: rgba(0, 0, 0, 0.2);
  top: -7px;
  left: 7px;
}
.bootstrap-datetimepicker-widget.dropdown-menu.bottom:after {
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-bottom: 6px solid white;
  top: -6px;
  left: 8px;
}
.bootstrap-datetimepicker-widget.dropdown-menu.top:before {
  border-left: 7px solid transparent;
  border-right: 7px solid transparent;
  border-top: 7px solid #cccccc;
  border-top-color: rgba(0, 0, 0, 0.2);
  bottom: -7px;
  left: 6px;
}
.bootstrap-datetimepicker-widget.dropdown-menu.top:after {
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-top: 6px solid white;
  bottom: -6px;
  left: 7px;
}
.bootstrap-datetimepicker-widget.dropdown-menu.pull-right:before {
  left: auto;
  right: 6px;
}
.bootstrap-datetimepicker-widget.dropdown-menu.pull-right:after {
  left: auto;
  right: 7px;
}
.bootstrap-datetimepicker-widget .list-unstyled {
  margin: 0;
}
.bootstrap-datetimepicker-widget a[data-action] {
  padding: 6px 0;
}
.bootstrap-datetimepicker-widget a[data-action]:active {
  box-shadow: none;
}
.bootstrap-datetimepicker-widget .timepicker-hour,
.bootstrap-datetimepicker-widget .timepicker-minute,
.bootstrap-datetimepicker-widget .timepicker-second {
  width: 54px;
  font-weight: bold;
  font-size: 1.2em;
  margin: 0;
}
.bootstrap-datetimepicker-widget button[data-action] {
  padding: 6px;
}
.bootstrap-datetimepicker-widget .btn[data-action="incrementHours"]::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Increment Hours";
}
.bootstrap-datetimepicker-widget .btn[data-action="incrementMinutes"]::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Increment Minutes";
}
.bootstrap-datetimepicker-widget .btn[data-action="decrementHours"]::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Decrement Hours";
}
.bootstrap-datetimepicker-widget .btn[data-action="decrementMinutes"]::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Decrement Minutes";
}
.bootstrap-datetimepicker-widget .btn[data-action="showHours"]::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Show Hours";
}
.bootstrap-datetimepicker-widget .btn[data-action="showMinutes"]::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Show Minutes";
}
.bootstrap-datetimepicker-widget .btn[data-action="togglePeriod"]::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Toggle AM/PM";
}
.bootstrap-datetimepicker-widget .btn[data-action="clear"]::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Clear the picker";
}
.bootstrap-datetimepicker-widget .btn[data-action="today"]::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Set the date to today";
}
.bootstrap-datetimepicker-widget .picker-switch {
  text-align: center;
}
.bootstrap-datetimepicker-widget .picker-switch::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Toggle Date and Time Screens";
}
.bootstrap-datetimepicker-widget .picker-switch td {
  padding: 0;
  margin: 0;
  height: auto;
  width: auto;
  line-height: inherit;
}
.bootstrap-datetimepicker-widget .picker-switch td span {
  line-height: 2.5;
  height: 2.5em;
  width: 100%;
}
.bootstrap-datetimepicker-widget table {
  width: 100%;
  margin: 0;
}
.bootstrap-datetimepicker-widget table td,
.bootstrap-datetimepicker-widget table th {
  text-align: center;
  border-radius: 4px;
}
.bootstrap-datetimepicker-widget table th {
  height: 20px;
  line-height: 20px;
  width: 20px;
}
.bootstrap-datetimepicker-widget table th.picker-switch {
  width: 145px;
}
.bootstrap-datetimepicker-widget table th.disabled,
.bootstrap-datetimepicker-widget table th.disabled:hover {
  background: none;
  color: #777777;
  cursor: not-allowed;
}
.bootstrap-datetimepicker-widget table th.prev::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Previous Month";
}
.bootstrap-datetimepicker-widget table th.next::after {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
  content: "Next Month";
}
.bootstrap-datetimepicker-widget table thead tr:first-child th {
  cursor: pointer;
}
.bootstrap-datetimepicker-widget table thead tr:first-child th:hover {
  background: #eeeeee;
}
.bootstrap-datetimepicker-widget table td {
  height: 54px;
  line-height: 54px;
  width: 54px;
}
.bootstrap-datetimepicker-widget table td.cw {
  font-size: .8em;
  height: 20px;
  line-height: 20px;
  color: #777777;
}
.bootstrap-datetimepicker-widget table td.day {
  height: 20px;
  line-height: 20px;
  width: 20px;
}
.bootstrap-datetimepicker-widget table td.day:hover,
.bootstrap-datetimepicker-widget table td.hour:hover,
.bootstrap-datetimepicker-widget table td.minute:hover,
.bootstrap-datetimepicker-widget table td.second:hover {
  background: #eeeeee;
  cursor: pointer;
}
.bootstrap-datetimepicker-widget table td.old,
.bootstrap-datetimepicker-widget table td.new {
  color: #777777;
}
.bootstrap-datetimepicker-widget table td.today {
  position: relative;
}
.bootstrap-datetimepicker-widget table td.today:before {
  content: '';
  display: inline-block;
  border: solid transparent;
  border-width: 0 0 7px 7px;
  border-bottom-color: #337ab7;
  border-top-color: rgba(0, 0, 0, 0.2);
  position: absolute;
  bottom: 4px;
  right: 4px;
}
.bootstrap-datetimepicker-widget table td.active,
.bootstrap-datetimepicker-widget table td.active:hover {
  background-color: #337ab7;
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
.bootstrap-datetimepicker-widget table td.active.today:before {
  border-bottom-color: #fff;
}
.bootstrap-datetimepicker-widget table td.disabled,
.bootstrap-datetimepicker-widget table td.disabled:hover {
  background: none;
  color: #777777;
  cursor: not-allowed;
}
.bootstrap-datetimepicker-widget table td span {
  display: inline-block;
  width: 54px;
  height: 54px;
  line-height: 54px;
  margin: 2px 1.5px;
  cursor: pointer;
  border-radius: 4px;
}
.bootstrap-datetimepicker-widget table td span:hover {
  background: #eeeeee;
}
.bootstrap-datetimepicker-widget table td span.active {
  background-color: #337ab7;
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
.bootstrap-datetimepicker-widget table td span.old {
  color: #777777;
}
.bootstrap-datetimepicker-widget table td span.disabled,
.bootstrap-datetimepicker-widget table td span.disabled:hover {
  background: none;
  color: #777777;
  cursor: not-allowed;
}
.bootstrap-datetimepicker-widget.usetwentyfour td.hour {
  height: 27px;
  line-height: 27px;
}
.bootstrap-datetimepicker-widget.wider {
  width: 21em;
}
.bootstrap-datetimepicker-widget .datepicker-decades .decade {
  line-height: 1.8em !important;
}
.input-group.date .input-group-addon {
  cursor: pointer;
}
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
}