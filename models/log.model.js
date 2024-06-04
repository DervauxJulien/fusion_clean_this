const { Timestamp } = require('mongodb');
const mongoose = require('mongoose');

const LogsSchema = mongoose.Schema(
    {
        user: {
            username: String,
            required: true,
        },

        actions: {
            type: String,
            required: true
        },
    },
    {
        timestamp: true
    }

);

const Logs = mongoose.model("CleanthisLog", "LogsSchema")