
const models = [
    {
        path: '/companies',
        name: 'Companies',
        props: {
            presentationText: "Lista cu companiile mele",
            addButton: {
                text: "Adauga o companie"
            },
            columns: {
                no: '#',
                name: 'Nume',
                address: 'Adresa',
            },
            endpoint: '/get',
            model: 'company',
            modalBlueprint: './modal/blueprints/addCompany.json',
        }
    },
    {
        path: '/partners',
        name: 'Parteneri',
        props: {
            presentationText: "Lista cu partenerii mele",
            addButton: {
                text: "Adauga un partener"
            },
            columns: {
                no: '#',
                name: 'Nume',
                address: 'Adresa',
            },
            endpoint: '/get',
            model: 'partner',
            modalBlueprint: './modal/blueprints/addPartner.json',
        }
    },
    {
        path: '/appendicies',
        name: 'Appendicies',
        props: {
            presentationText: "Lista cu anexele",
            addButton: {
                text: "Adauga o anexa"
            },
            columns: {
                no: '#',
                seriesNo: 'Nr. / Serie',
                date: 'Data',
                contract: 'Contract',
                value: 'Valoare',
            },
            endpoint: '/get',
            model: 'appendix',
            modalBlueprint: './modal/blueprints/addAppendix.json',
        }
    },
]

export default models