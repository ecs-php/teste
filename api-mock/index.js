const Koa = require('koa')
const Router = require('koa-router')
const BodyParser = require('koa-bodyparser')
const koaBody = require('koa-body')
const CORS = require('kcors')
const app = new Koa()
const router = new Router()

app.use(CORS({
    allowMethods: ["GET,HEAD,PUT,PATCH,POST,DELETE"]
}))

app.use(koaBody({ multipart: true }))
app.use(BodyParser())

router
    .get("/calendar", async (ctx) => {
        ctx.status = 200
        ctx.body = [
            "23/11",
            "30/11",
            "07/12",
            "14/12",
            "21/12",
            "28/12",
            "04/01",
            "11/01",
            "18/01",
            "25/01",
            "01/02",
            "08/02",
            "15/02",
            "22/02",
            "01/03",
            "08/03",
            "15/03",
            "22/03",
            "29/03",
            "05/04"
        ]
    }).get("/winners", async (ctx) => {
        ctx.status = 200
        ctx.body = [
            {
                city: "Rio de Janeiro",
                number: "24852",
                date: "23/11"
            },
            {
                city: "Ceará",
                number: "32977",
                date: "30/11"
            },
            {
                city: "São Paulo",
                number: "00992",
                date: "07/12"
            },
            {
                city: "São Paulo",
                number: "38566",
                date: "14/12"
            },
            {
                city: "Paraná",
                number: "93643",
                date: "21/12"
            },
            {
                city: "Minas Gerais",
                number: "68678",
                date: "28/12"
            }
        ]
    })

app.use(router.routes())
    .use(router.allowedMethods())


app.listen(7700)