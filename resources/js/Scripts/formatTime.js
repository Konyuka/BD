
import moment from "moment";

export function formatTime(time) {
    return moment(time).format('ll');
}
