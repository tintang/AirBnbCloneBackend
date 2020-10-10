class AuthenticationApi {
    login(values: Object, callback: Function) {
        fetch('http://localhost/api/login_check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(values)
        })
            .then((res) => res.json())
            .then(body => {
                if (body.token) {
                    callback(body.token);
                }
            })
            .catch((err) => {
                console.log(err);
            })
    }
}

export default new AuthenticationApi();