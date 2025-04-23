CREATE DATABASE cms;

DO $$
BEGIN
   IF EXISTS (SELECT FROM pg_roles WHERE rolname = 'postgres') THEN
      ALTER ROLE postgres WITH PASSWORD 'mypassword';
      ALTER ROLE postgres CREATEDB;
      ALTER ROLE postgres SUPERUSER;
   END IF;
END
$$;
