import store from "../store"

const notifyError = err => {
    if(err.response) {
        if (err.response.data) {
            if (err.response.data.hasOwnProperty("message")) {
                store.dispatch("setErrorNotification", err.response.data.message);
            }else{
                store.dispatch("setErrorNotification", err.response.data.error);
            }
            setTimeout(() => {
                store.dispatch("setErrorNotification", "");
            }, 5000);
        }
    }
}

const notifySuccess = message => {
    store.dispatch("setSuccessNotification", message);
    setTimeout(() => {
        store.dispatch("setSuccessNotification", "");
    }, 5000);
}

export default { 
    notifyError, 
    notifySuccess 
}