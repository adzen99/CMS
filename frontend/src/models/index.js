
const models = [
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
            model: 'appendix'
        }
    },
]

export default models