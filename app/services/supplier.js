const URL = "../../Controllers/supplierController.php";

export async function listSuppliers() {
    let formData = new FormData();
    formData.append('action', 'ListSuppliers');
    
    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData,
            cache: "no-store"
        })
    
        return await res.text()
    } catch (error) {
        console.log(error)
    }
}

export async function addSupplier(formData){
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
        return {status: "error", message: error.message }
    }
} 


export async function getSupplierById(id) {
    let formData = new FormData()
    formData.append('id', id)
    formData.append('action', "GetSupplierById")

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){    
            return await res.json()
        } else {
            throw new Error("No se encontro el proveedor")
        }
    } catch (error) {
        return {status: "error", message: error.message }
    }
}


export async function editSupplier(formData) {
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
        return {status: "error", message: error.message }
    }
}


export async function deleteSupplier(formData) {
    formData.append('action', 'Delete')

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){    
            return await res.json()
        } else {
            throw new Error("No se pudo eliminar el proveedor")
        }
    } catch (error) {
        return {status: "error", message: error.message }
    }
}