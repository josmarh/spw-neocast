import store from "../store"

const notifyError = err => {
    let message;
    if(err.response) {
        if (err.response.data) {
            if (err.response.data.hasOwnProperty("message")) {
                store.dispatch("setErrorNotification", err.response.data.message);
                message =  err.response.data.message
            }else{
                store.dispatch("setErrorNotification", err.response.data.error);
                message =  err.response.data.error
            }
            setTimeout(() => {
                store.dispatch("setErrorNotification", "");
            }, 5000);
        }else{
            message =  'Something went wrong, please try again.'
        }
    }else{
        message =  'Something went wrong, please try again.'
    }
    return message;
}

const notifyError2 = message => {
    store.dispatch("setErrorNotification", message);
    setTimeout(() => {
        store.dispatch("setErrorNotification", "");
    }, 5000);
}

const notifySuccess = message => {
    store.dispatch("setSuccessNotification", message);
    setTimeout(() => {
        store.dispatch("setSuccessNotification", "");
    }, 5000);
}

export default { 
    notifyError,
    notifyError2,
    notifySuccess 
}