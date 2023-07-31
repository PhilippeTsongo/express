export class Access
{
    constructor(_ACCESS_) {
        this.ACCESS = (_ACCESS_);
    }

    granted(task) {
        let granted = JSON.parse(this.ACCESS);
        return granted.some((item) => {
            return item.task === task;
        });
    }
}