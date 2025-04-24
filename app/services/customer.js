const URL = "../../Controllers/customerController.php";

export async function listCustomers() {
    let formData = new FormData();
    formData.append('action', 'ListCustomers');
    
    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData,
            cache: "no-store"
        })

        if (res.ok){
            return await res.text()
        } else {
            throw new Error("Error al traer los datos")
        }
    
    } catch (error) {
        console.log(error.message)
    }
}

export async function addCustomer(formData){
    formData.append("action", 'Create');

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){
            return await res.json()
        } else {
            const data = await res.json()
            throw new Error(data.message)
        }
    } catch (error) {
        return {status: "error", message: error.message}
    }
} 


export async function getCustomerById(id) {
    let formData = new FormData()
    formData.append('id', id)
    formData.append('action', "GetCustomerById")

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){
            return await res.json()
        } else {
            throw new Error("No se encontro el cliente")
        }
    } catch (error) {
        return {status: "error", message: error.message}
    }
}


export async function editCustomer(formData) {
    formData.append('action', 'Update')

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){
            return await res.json()
        } else {
            const data = await res.json()
            throw new Error(data.message)
        }
    } catch (error) {
        console.log("error en seriveice", error)
        return {status: "error", message: error.message}
    }
}


export async function deleteCustomer(formData) {
    formData.append('action', 'Delete')

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){
            return await res.json()
        } else {
            throw new Error("No se pudo elimniar el cliente")
        }
    } catch (error) {
        return {status: "error", message: error.message}
    }
}