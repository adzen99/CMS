from app.models.company import Company


class Model:
    def __init__(self, model, data):
        self.__model = model
        self.__data = data
        self.result = self.__establish_model()
    
    def __establish_model(self):
        if self.__model == 'company':
            return Company(
                name=self.__data['name'],
                address=self.__data['address'],
                county=self.__data['county'],
                locality=self.__data['locality'],
                cui=self.__data['cui'],
                nr_reg=self.__data['nr_reg'],
                iban=self.__data['iban'],
                id_user=0,
                # id_user=self.__data['id_user'],
            )