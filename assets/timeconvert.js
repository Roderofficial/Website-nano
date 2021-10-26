function timeconvert(time){
    var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone
    var time_obj = moment.utc(time).tz(timezone);
    return moment(time_obj).format('YYYY-MM-DD HH:mm:ss');
}
function hourconvert(time){
    var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone
    var format = 'HH:mm'
    var time_obj = moment.utc(time, format).tz(timezone);
    return moment(time_obj).format('HH:mm');
    

}