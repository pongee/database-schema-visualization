CREATE TYPE message (
  id UUID,
  sometext text,
  othertext VARCHAR,
  created TIMESTAMP,
  flags map <VARCHAR, boolean>,
  data map<varchar, varchar>
);

CREATE TABLE IF NOT EXISTS user_messages (
  user_id UUID,
  type_id varchar,
  messages map<UUID,frozen <message>>,
  PRIMARY KEY (user_id, type_id)
);
