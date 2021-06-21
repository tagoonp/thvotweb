'use strict';

/* eslint-disable require-jsdoc, no-unused-vars */

var CalendarList = [],
  primaryColor = "#5A8DEE",
  primaryLight = "#E2ECFF",
  secondaryColor = "#475F7B",
  secondaryLight = "#E6EAEE",
  successColor = "#39DA8A",
  successLight = "#D2FFE8",
  dangercolor = "#FF5B5C",
  dangerLight = "#FFDEDE",
  warningColor = "#FDAC41",
  warningLight = "#FFEED9",
  infoColor = "#00CFDD",
  infoLight = "#CCF5F8 ",
  lightColor = "#b3c0ce",
  veryLightBlue = "#e7edf3",
  cloudyBlue = "#b3c0ce";
// contructor to create event
function CalendarInfo() {
  this.id = null;
  this.name = null;
  this.checked = true;
  this.color = null;
  this.bgColor = null;
  this.borderColor = null;
}

function addCalendar(calendar) {
  CalendarList.push(calendar);
}

function findCalendar(id) {
  var found;

  CalendarList.forEach(function (calendar) {
    if (calendar.id === id) {
      found = calendar;
    }
  });

  return found || CalendarList[0];
}
// sidebar calendar list
(function () {
  // var calendar;
  // var id = 0;

  // var calendar_1 = new CalendarInfo();
  // id += 1;
  // calendar_1.id = String(id);
  // calendar_1.name = 'My Calendar';
  // calendar_1.color = infoColor;
  // calendar_1.bgColor = infoLight;
  // calendar_1.dragBgColor = infoColor;
  // calendar_1.borderColor = infoColor;
  // addCalendar(calendar_1);

  // calendar_1.createSchedules([
  //   {
  //       id: '1',
  //       calendarId: '1',
  //       title: 'my schedule',
  //       category: 'time',
  //       dueDateClass: '',
  //       start: '2021-06-18T22:30:00+09:00',
  //       end: '2021-06-19T02:30:00+09:00'
  //   },
  //   {
  //       id: '2',
  //       calendarId: '1',
  //       title: 'second schedule',
  //       category: 'time',
  //       dueDateClass: '',
  //       start: '2021-06-10T17:30:00+09:00',
  //       end: '2021-06-12T17:31:00+09:00',
  //       isReadOnly: true    // schedule is read-only
  //   }
  // ]);

  // calendar = new CalendarInfo();
  // id += 1;
  // calendar.id = String(id);
  // calendar.name = 'Company';
  // calendar.color = primaryColor;
  // calendar.bgColor = primaryLight;
  // calendar.dragBgColor = primaryColor;
  // calendar.borderColor = primaryColor;
  // addCalendar(calendar);

  // calendar = new CalendarInfo();
  // id += 1;
  // calendar.id = String(id);
  // calendar.name = 'Family';
  // calendar.color = secondaryColor;
  // calendar.bgColor = secondaryLight;
  // calendar.dragBgColor = secondaryColor;
  // calendar.borderColor = secondaryColor;
  // addCalendar(calendar);

  // calendar = new CalendarInfo();
  // id += 1;
  // calendar.id = String(id);
  // calendar.name = 'Friend';
  // calendar.color = successColor;
  // calendar.bgColor = successLight;
  // calendar.dragBgColor = successColor;
  // calendar.borderColor = successColor;
  // addCalendar(calendar);

  // calendar = new CalendarInfo();
  // id += 1;
  // calendar.id = String(id);
  // calendar.name = 'Travel';
  // calendar.color = warningColor;
  // calendar.bgColor = warningLight;
  // calendar.dragBgColor = warningColor;
  // calendar.borderColor = warningColor;
  // addCalendar(calendar);

})();


