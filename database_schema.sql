
                                                                                                                
                                           APPLICATION IN PRODUCTION.                                           
                                                                                                                

  Are you sure you want to run this command? (yes/no) [no]
❯ 
   WARN  The SQLite database configured for this application does not exist: C:\Users\abreu\Desktop\testefinal\faltometro\database\database.sqlite.  

  Would you like to create it? (yes/no) [yes]
❯ 
   INFO  Preparing database.  

  Creating migration table ...................................................................... 12.09ms DONE

   INFO  Running migrations.  

  0001_01_01_000000_create_users_table .......................................................................  
  ⇂ create table "users" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "email_verified_at" datetime, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime)  
  ⇂ create unique index "users_email_unique" on "users" ("email")  
  ⇂ create table "password_reset_tokens" ("email" varchar not null, "token" varchar not null, "created_at" datetime, primary key ("email"))  
  ⇂ create table "sessions" ("id" varchar not null, "user_id" integer, "ip_address" varchar, "user_agent" text, "payload" text not null, "last_activity" integer not null, primary key ("id"))  
  ⇂ create index "sessions_user_id_index" on "sessions" ("user_id")  
  ⇂ create index "sessions_last_activity_index" on "sessions" ("last_activity")  
  0001_01_01_000001_create_cache_table .......................................................................  
  ⇂ create table "cache" ("key" varchar not null, "value" text not null, "expiration" integer not null, primary key ("key"))  
  ⇂ create table "cache_locks" ("key" varchar not null, "owner" varchar not null, "expiration" integer not null, primary key ("key"))  
  0001_01_01_000002_create_jobs_table ........................................................................  
  ⇂ create table "jobs" ("id" integer primary key autoincrement not null, "queue" varchar not null, "payload" text not null, "attempts" integer not null, "reserved_at" integer, "available_at" integer not null, "created_at" integer not null)  
  ⇂ create index "jobs_queue_index" on "jobs" ("queue")  
  ⇂ create table "job_batches" ("id" varchar not null, "name" varchar not null, "total_jobs" integer not null, "pending_jobs" integer not null, "failed_jobs" integer not null, "failed_job_ids" text not null, "options" text, "cancelled_at" integer, "created_at" integer not null, "finished_at" integer, primary key ("id"))  
  ⇂ create table "failed_jobs" ("id" integer primary key autoincrement not null, "uuid" varchar not null, "connection" text not null, "queue" text not null, "payload" text not null, "exception" text not null, "failed_at" datetime not null default CURRENT_TIMESTAMP)  
  ⇂ create unique index "failed_jobs_uuid_unique" on "failed_jobs" ("uuid")  
  2025_07_10_005708_create_subjects_table ....................................................................  
  ⇂ create table "subjects" ("id" integer primary key autoincrement not null, "name" varchar not null, "workload" integer not null, "absences_limit" integer not null, "user_id" integer not null, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade)  
  2025_07_10_103530_create_absences_table ....................................................................  
  ⇂ create table "absences" ("id" integer primary key autoincrement not null, "subject_id" integer not null, "absence_date" date not null, "quantity" integer not null default '1', "description" varchar, "created_at" datetime, "updated_at" datetime, foreign key("subject_id") references "subjects"("id") on delete cascade)  
  2025_07_10_130505_create_grades_table ......................................................................  
  ⇂ create table "grades" ("id" integer primary key autoincrement not null, "subject_id" integer not null, "name" varchar not null, "weight" numeric not null, "value" numeric, "created_at" datetime, "updated_at" datetime, foreign key("subject_id") references "subjects"("id") on delete cascade)  

