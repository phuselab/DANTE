function WV = WeightedVoting(samplesMatrix)
    stdDev = std(samplesMatrix);
    WV = (samplesMatrix * stdDev')/sum(stdDev);
end