from fastapi import FastAPI, Depends, HTTPException, status
from fastapi.openapi.docs import get_swagger_ui_html
from fastapi.openapi.utils import get_openapi
from fastapi.middleware.cors import CORSMiddleware
# from app.routers import user, advertisement
from app.database import engine
from app.models import Base
from fastapi.staticfiles import StaticFiles
from fastapi.security import HTTPBasic, HTTPBasicCredentials
from dotenv import load_dotenv
import os

load_dotenv()

Base.metadata.create_all(bind=engine)

app = FastAPI(docs_url=None, redoc_url=None)

security = HTTPBasic()

def authenticate(credentials: HTTPBasicCredentials = Depends(security)):
    correct_username = os.getenv("SWAGGER_USERNAME", "admin")
    correct_password = os.getenv("SWAGGER_PASSWORD", "secret")
    if credentials.username != correct_username or credentials.password != correct_password:
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="Unauthorized",
            headers={"WWW-Authenticate": "Basic"},
        )
    

@app.get("/docs", include_in_schema=False)
def custom_swagger_ui(credentials: HTTPBasicCredentials = Depends(authenticate)):
    return get_swagger_ui_html(openapi_url="/openapi.json", title="Protected Swagger UI")


@app.get("/openapi.json", include_in_schema=False)
def openapi(credentials: HTTPBasicCredentials = Depends(authenticate)):
    return get_openapi(title=app.title, version=app.version, routes=app.routes)

app.mount("/db_images", StaticFiles(directory="app/db_images"), name="db_images")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["http://localhost:5173"],
    allow_credentials=True,
    allow_methods=["*"], 
    allow_headers=["*"],
)

# app.include_router(user.router, prefix="/api")
# app.include_router(advertisement.router, prefix="/api")