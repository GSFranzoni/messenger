import { Notify } from 'quasar';

export const baseApiUrl = 'http://localhost:8100';

export const colors = [
    'orange', 'pink', 'purple', 'deep-purple', 'indigo', 'blue', 'light-blue', 'cyan', 'teal', 'green',
    'light-green', 'lime', 'yellow', 'amber', 'orange', 'deep-orange', 'brown', 'blue-grey'
]

export function getRandomColor() {
    const colorIndex = parseInt(Math.random() * colors.length);
    const colorLevel = 5 + parseInt(Math.random() * 5);
    return `${colors[colorIndex]}${colorLevel > 0 ? "-" + colorLevel : ""}`;
}

export function getFormattedDate(date) {
    const dateStr =
        `${date.getFullYear()}-`+
        `00${date.getMonth()+1}`.slice(-2)+"-"+
        `00${date.getDate()}`.slice(-2)+ " " +
        `00${date.getHours()}`.slice(-2)+":"+
        `00${date.getMinutes()}`.slice(-2)+":"+
        `00${date.getSeconds()}`.slice(-2)
    return dateStr;
}

export function successMessage({message, position='bottom'}) {
    Notify.create({
        message,
        position,
        icon: 'check_circle',
        timeout: 3000,
        textColor: 'white',
        color: 'green'
    });
}

export function errorMessage({message, position='bottom'}) {
    Notify.create({
        message,
        position,
        icon: 'cancel',
        timeout: 3000,
        textColor: 'white',
        color: 'red'
    });
}

export default { baseApiUrl, getRandomColor, getFormattedDate, successMessage, errorMessage };