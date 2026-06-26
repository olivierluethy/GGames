# Migrations

Incremental SQL migrations for upgrading an **existing** GGames database.
Each file is numbered and applied in order.

> Fresh installs don't need these — `docker/mysql/init/01-schema.sql` +
> `02-seed.sql` already contain the consolidated final schema and seed data.
> These migrations exist to upgrade a database that was created before a change.

## Applying

Against the Docker database container:

```sh
for m in migrations/*.sql; do
  docker exec -i ggames-db mysql -uroot -proot ggames < "$m"
done
```

Or a single migration:

```sh
docker exec -i ggames-db mysql -uroot -proot ggames < migrations/001_game_meta_and_price_history.sql
```

## Files

| #   | File                                   | Adds                                                        |
| --- | -------------------------------------- | ---------------------------------------------------------- |
| 001 | `001_game_meta_and_price_history.sql`  | game `description` + `created_at`, numeric prices, `price_history` |
| 002 | `002_game_images.sql`                  | `game_images` (URL/base64 covers + screenshots)            |
| 003 | `003_purchase_details.sql`             | `kaeufe.price_paid` + `purchased_at`                       |
| 004 | `004_payment_cards.sql`                | `payment_cards` (dummy, simulated)                         |
| 005 | `005_friends.sql`                      | `friends` relationships                                    |
