
export function reverseDate(originalDate) {
    const parts = originalDate.split(' ');

    if (parts.length === 2) {
        const datePart = parts[0].split('-');
        const reversedDate = `${datePart[1]}-${datePart[0]}-${datePart[2]}`; 
        const reversedDateStr = `${reversedDate} ${parts[1]}`;
        return reversedDateStr;
    } else {
        return "Invalid date format";
    }
}
