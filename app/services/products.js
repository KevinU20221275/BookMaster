const URL = "../../Controllers/productController.php"

export async function listProducts() {
    let formData = new FormData();
    formData.append('action', 'ListProducts');
    
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

export async function addProduct(formData){
    formData.append("action", 'Create');

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){    
            return await res.json()
        } else {
            const data =  await res.json()
            throw new Error(data.message)
        }
    } catch (error) {
        return {status: "error", message: error.message}
    }
} 


export async function getProductById(id) {
    let formData = new FormData()
    formData.append('id', id)
    formData.append('action', "GetProductById")

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){
            return await res.json()
        } else {
            throw new Error("No se encontro el producto")
        }

    } catch (error) {
        return {status: "error", message: error.message}
    }
}


export async function editProduct(formData) {
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
        return {status: "error", message: error.message}
    }
}


export async function deleteProduct(formData) {
    formData.append('action', 'Delete')

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        if (res.ok){    
            return await res.json()
        } else {
            throw new Error("No se pudo eliminar el producto")
        }
    } catch (error) {
        return {status: "error", message: error.message}
    }
}

export async function getSuppliersForSelect() {
    let formData = new FormData();
    formData.append('action', 'GetSuppliers')

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })
        
        return res.text()
    } catch (error) {
        console.log(error)
    }
}