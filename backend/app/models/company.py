from sqlalchemy import Column, ForeignKey, Integer, String
from app.models import Base


class Company(Base):
    __tablename__ = 'companies'

    id = Column(Integer, primary_key=True, index=True)
    name = Column(String, index=True)
    address = Column(String)
    county = Column(String, index=True)
    locality = Column(String, index=True)
    cui = Column(String, index=True)
    nr_reg = Column(String, index=True)
    iban = Column(String, index=True)
    id_user = Column(Integer, ForeignKey("users.id"), nullable=False)
