/**
 * Calls the startTime and setOnThisDay functions when the window finishes loading
 */
window.onload = function() {
    setOnThisDay();
    startTime();
}

/**
 * Updates the page every second with the current time in a 12 hour format and current date.
 */
function startTime() {
    var today = new Date();

    // Get the current date and time details
    var month = today.toLocaleDateString('en-US', { month: 'long' }); // Long format Month name
    var day = today.getDate(); // Day of the month
    var dayOfWeek = today.toLocaleDateString('en-US', { weekday: 'short' }); // Short format Day of the week
    var hours = today.getHours() % 12 || 12; // Hours in 12h format
    var m = today.getMinutes();
    m = checkTime(m); // Minutes with leading zero if < 10
    var meridian = today.getHours() >= 12 ? 'pm' : 'am'; // AM or PM indicator

    var time = hours + ":" + m;

    // Display the date and time details on the webpage
    document.getElementById('day-of-week').innerHTML = dayOfWeek;
    document.getElementById('month').innerHTML = month;
    document.getElementById('day-of-month').innerHTML = day;
    document.getElementById('hours-minutes').innerHTML = time;
    document.getElementById('meridian').innerHTML = meridian;

    // Update the time every second
    setTimeout(startTime, 1000);
}

/**
 * add zero in front of numbers < 10
 * @param {Number} i - the minute or second
 * @returns {String} A string representation of the time value, with a leading zero if the original value was < 10
 */
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

/**
 * Selects a random event from the input array.
 * @param {Array} events - An array of events
 * @returns {Object} A randomly selected event
 */
function getRandom(events = []) {
    return events[Math.floor(Math.random() * events.length)];
}

/**
 * Periodically triggers a random event on the page that can be either a birth, a death, or a generic event.
 *
 * This function first selects a random number to decide the type of the event, then retrieves a random event of
 * the selected type. After displaying the selected event, it will wait one minute before choosing and displaying a
 * new random event.
 */
function setOnThisDay() {

    // Get a random number between 0 and 3
    var random = Math.floor(Math.random() * 4);

    var event;
    var type;

    // Determine type of event based on random number
    if (random == 0) {
        event = getRandom(births);
        type = 'birth';
    } else if (random == 1) {
        event = getRandom(deaths);
        type = 'death';
    } else {
        event = getRandom(events);
        type = 'event';
    }

    // Set and display the event
    setEvent(type, event);

    // Wait one minute, then trigger another random event
    setTimeout(setOnThisDay, 60000);
}

/**
 * Sets and displays event details based on type and event information
 *
 * @param {string} type - category of event, i.e., 'birth' or 'death'.
 * @param {object} event - contains event-related data, including year and text.
 */
function setEvent(type, event) {

    var title = '';

    // Determine title based on type of event
    if (type == "birth") {
        title = 'Born ';
    } else if (type == "death") {
        title = 'Died ';
    }

    // Determine bottom margin based on length of event text
    if (event.text.length > 73 && event.text.length < 153) {
        document.getElementById('time').style.marginBottom = '21px';
    } else if (event.text.length >= 153 && event.text.length < 223) {
        document.getElementById('time').style.marginBottom = '2px';
    } else if (event.text.length >= 223) {
        document.getElementById('time').style.marginBottom = '-18px';
    } else {
        document.getElementById('time').style.marginBottom = '42px';
    }

    // Display event details
    document.getElementById('event-type').innerHTML = title;
    document.getElementById('event-year').innerHTML = event.year;
    document.getElementById('onthisday-event').innerHTML = event.text;
}