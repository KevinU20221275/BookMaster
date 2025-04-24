const URL = "../../Controllers/saleController.php";

export async function listSales() {
    let formData = new FormData();
    formData.append('action', 'ListSales');
    
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

export async function addSale(formData){
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


export async function getSaleById(id) {
    let formData = new FormData()
    formData.append('id', id)
    formData.append('action', "GetSaleById")

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        return await res.json()
    } catch (error) {
        console.log(error)
    }
}

export async function getSaleDetails(id){
    let formData = new FormData();
    formData.append("id", id);
    formData.append("action", "GetSaleDetails");
    
    try {
        const res =  await fetch(URL, {
            method: "POST",
            body: formData,
            })

        return await res.text()
    } catch (error) {
        console.log(error)
    }
}

export async function listCustomerForSelect(){
    let formData = new FormData();
    formData.append('action', 'GetCustomers');

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })
    
        return await res.text()
    } catch (error) {
        console.error(error)
    }
}

export async function listProductsForSelect(){
    let formData = new FormData();
    formData.append('action', 'GetProducts');

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })
    
        return await res.text()
    } catch (error) {
        console.log(error)
    }
}


export async function editSale(formData) {
    formData.append('action', 'Update')

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })
    
        return await res.json()
    } catch (error) {
        console.log(error)
    }
}


export async function deleteSale(formData) {
    formData.append('action', 'Delete')

    try {
        const res = await fetch(URL, {
            method: "POST",
            body: formData
        })

        return await res.text()
    } catch (error) {
        console.log(error)
    }
}